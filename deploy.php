<?php
namespace Deployer;

use Deployer\Task\Context;
use Deployer\Utility\Httpie;


require 'recipe/laravel.php';
require 'vendor/deployer/recipes/recipe/npm.php';

// Project name

// Discord config

set('deploy_path', '/var/www/html');
set('application', 'Emodyz Indexer');
// Project repository
set('repository', 'git@gitlab.elios-mirror.com:elios/Admin.git');
// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
// Shared files/dirs between deploys
set('shared_files', [
    '.env'
]);
// Laravel shared dirs
set('shared_dirs', [
    'storage'
]);
// Writable dirs by web server
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

host('dev')
    ->user('root')
    ->hostname('dev.elios-mirror.com')
    ->identityFile('./ssh_key/id_rsa')
    ->set('branch', 'dev');

task('upload:env', function () {
    upload('.env.production',  '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

task('build:js', function() {
    runLocally('npm run prod');
});

task('run:sockets', function() {
    run('screen -dm bash -c "cd /var/www/html/release/sockets; npm install; killall node; npm run dev"');
});

task('passport:install', function() {
    run('cd {{deploy_path}}/release; php artisan passport:install --force ');
});

// [Optional] if deploy fails automatically unlock
//.
after('deploy:failed', 'deploy:unlock');
after('artisan:optimize', 'upload:env');
after('upload:env', 'passport:install');
//after('deploy:prepare', 'build:js');
// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
after('deploy:update_code', 'run:sockets');

// Discord notifications
before('deploy:prepare', 'discord:notify');
after('success', 'discord:notify:success');
after('deploy:failed', 'discord:notify:failure');


/**
 * Discord
 */

set('discord_webhook', function () {
    return 'https://discordapp.com/api/webhooks/449217228882313216/WNRX4Jhl45U5KZ7C2FImiR8l8nnsngMCGOcr_7F5E5TAKOWszLZim3urN_JI7Pe5MpRF';
});

// Deploy messages
set('discord_notify_text', ':information_source: **{{user}}** is deploying branch `{{branch}}` to _{{target}}_');
set('discord_success_text', ':white_check_mark: Branch `{{branch}}` deployed to _{{target}}_ successfully');
set('discord_failure_text', ':no_entry_sign: Branch `{{branch}}` has failed to deploy to _{{target}}_');

set('discord_type', 'discord_notify_text');

// Helpers
task('discord_send_message', function(){
    Httpie::post(get('discord_webhook'))->body(['content' => get(get('discord_type'))])->send();
});

// Tasks
desc('Just notify your Discord channel with all messages, without deploying');
task('discord:test', function () {
    set('discord_type', 'discord_notify_text');
    invoke('discord_send_message');
    set('discord_type', 'discord_success_text');
    invoke('discord_send_message');
    set('discord_type', 'discord_failure_text');
    invoke('discord_send_message');
})
    ->once()
    ->shallow();

desc('Notify Discord');
task('discord:notify', function () {
    set('discord_type', 'discord_notify_text');
    invoke('discord_send_message');
})
    ->once()
    ->shallow()
    ->isPrivate();

desc('Notify Discord about deploy finish');
task('discord:notify:success', function () {
    set('discord_type', 'discord_success_text');
    invoke('discord_send_message');
})
    ->once()
    ->shallow()
    ->isPrivate();

desc('Notify Discord about deploy failure');
task('discord:notify:failure', function () {
    set('discord_type', 'discord_failure_text');
    invoke('discord_send_message');
})
    ->once()
    ->shallow()
    ->isPrivate();

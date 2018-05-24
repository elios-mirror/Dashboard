<?php
namespace Deployer;

require 'recipe/laravel.php';
// Project name

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
    ->set('branch', 'dev');

task('upload:env', function () {
    upload('.env.production',  '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

task('build:js', function() {
    runLocally('npm run prod');
});

// [Optional] if deploy fails automatically unlock
//.
after('deploy:failed', 'deploy:unlock');
after('artisan:optimize', 'upload:env');
after('deploy:prepare', 'build:js');
// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Elios Mirror');

// Project repository
set('repository', 'git@gitlab.elios-mirror.com:elios/Admin.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys 
set('shared_files', [
    '.env'
]);
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
set('allow_anonymous_stats', false);

set('default_stage', 'dev');

// Hosts


host('current')
    ->stage('current')
    ->user('root')
    ->port(22)
    ->hostname('dev.elios-mirror.com')
    ->set('deploy_path', '/var/www/dev')
    ->set('env_path', 'environements/env.preproduction');

host('dev')
    ->stage('dev')
    ->user('root')
    ->port(22)
    ->hostname('dev.elios-mirror.com')
    ->set('deploy_path', '/var/www/dev')
    ->set('env_path', 'environements/env.preproduction')
    ->set('branch', 'dev');

host('prod')
    ->stage('production')
    ->user('root')
    ->port(22)
    ->hostname('api.elios-mirror.com')
    ->set('deploy_path', '/var/www/prod')
    ->set('env_path', 'environements/env.production')
    ->set('branch', 'master');


task('what_branch', function () {
  $branch = ask('What branch to deploy?');

  set('branch', $branch);
})->local();

// Upload and reload .env
task('upload:env', function () {
  upload('{{env_path}}', '{{deploy_path}}/shared/.env');
  run('cd {{deploy_path}}/release; php artisan clear-compiled; php artisan config:clear; php artisan config:cache; php artisan cache:clear; php artisan route:clear; php artisan optimize:clear; systemctl restart php7.2-fpm;');
})->desc('Environment setup');

// Dev tasks 
task('artisan:migrate', function () {
  $stage = get('stage');
  if ($stage == "production")
    run('cd {{deploy_path}}/release; php artisan migrate');
  else
    run('cd {{deploy_path}}/release; php artisan migrate:fresh --seed --force');
});

// Tasks

// Upload ENV before passport:install 
after('artisan:optimize', 'upload:env');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');


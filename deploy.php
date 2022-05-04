<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'DashIMSI');

// Project repository
set('repository', 'git@github.com:c3t4r4/DashIMSI.git');


// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

// Production
set('branch', 'main');
host('ubuntu@152.67.33.97')->set('deploy_path', '/var/www/DashIMSI');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy:composer_install', function() {
    run('cd {{release_path}} && composer install && composer require owen-it/laravel-auditing');
});

task('deploy:npm_install', function() {
    run('cd {{release_path}} && npm install && npm run prod');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

// Custom Tasks
after('success',  'deploy:composer_install');
after('success',  'deploy:npm_install');


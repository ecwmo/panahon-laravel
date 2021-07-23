# Panahon App

## Installation

1. Install [server requirements](https://laravel.com/docs/8.x/deployment#server-requirements).
2. Install [composer](https://getcomposer.org/download/).
3. Install yarn.
4. Configuration.
    - create a .env (copy .env.example and rename it to .env)
    - set APP_URL
    - set APP_ENV=production, APP_DEBUG=false
    - setup database
        - DB_CONNECTION=pgsql
5. `composer install --optimize-autoloader --no-dev`
6. (if deploying as a subfolder) edit webpack.mix.js and add `mix.setResourceRoot('/<subfolder name>/');`
7. `yarn development`
8. See [optimizations settings](https://laravel.com/docs/8.x/deployment#optimization).

## Updating

1. Enable maintenance mode: `php artisan down`
2. Pull updates. `git pull`
3. Disable maintenance mode: `php artisan up`

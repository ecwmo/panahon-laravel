# Panahon App

## Installation

1. Install [server requirements](https://laravel.com/docs/9.x/deployment#server-requirements).
2. Install [composer](https://getcomposer.org/download/).
3. Install yarn.
4. Configuration.
   - create a .env (copy .env.example and rename it to .env)
   - set APP_URL
   - set APP_ENV=production, APP_DEBUG=false
   - setup database
     - DB_CONNECTION=pgsql
5. Deploy

```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
yarn
yarn build

# as a subfolder
# yarn build --base=/<subfolder>/
```

## Updating

1. Enable maintenance mode: `php artisan down`
2. Pull updates. `git pull`
3. Deploy

```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
yarn
yarn build

# as a subfolder
# yarn build --base=/<subfolder>/
```

4. Disable maintenance mode: `php artisan up`

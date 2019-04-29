## Requirements

- PHP 7/<
- Apache/Nginx
- PostgreSQL
- Composer
- NPM

## Installation

1. Clone the repo
2. Run `npm i` and then `composer install`
3. When PostgreSQL is installed and configured run `php artisan migrate`
4. Then run `php artisan db:seed`

## Run

1. Run `php artisan serve` - For the virtual server
2. Run `npm run watch` - For the SCSS and JS build on change

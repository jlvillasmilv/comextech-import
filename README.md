# Laravel 8.0+ Jetstream and Tailwind CSS Admin Theme

This project is created with [Laravel Jetstream] Framework and [Tailwind CSS](https://tailwindcss.com), the admin environment is desing by [Windmill Dashboard](https://windmill-dashboard.vercel.app/).

## Requirements

- Laravel installer
- Composer
- Npm installer

## Installation

```
# Clone the repository from GitHub and open the directory:
git clone https://github.com/keiwerkgvr/comextech-import.git

# cd into your project directory
cd larawind

#install composer and npm packages
composer install
npm install && npm run dev

# Start prepare the environment:
cp .env.example .env // setup database credentials
php artisan key:generate
php artisan migrate
php artisan storage:link

# Run your server
php artisan serve

```
### Project made possible thanks to:

- [Laravel Jetstream](https://jetstream.laravel.com/1.x/introduction.html)
- [Tailwind CSS](https://tailwindcss.com/)
- [Windmill Dashboard](https://windmill-dashboard.vercel.app/)

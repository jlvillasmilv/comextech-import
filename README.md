# Laravel 8.0+ Jetstream and Tailwind CSS Admin Theme

This project is created with [Laravel Jetstream] Framework and [Tailwind CSS](https://tailwindcss.com), the admin environment is desing by [Windmill Dashboard](https://windmill-dashboard.vercel.app/).

[<img src="https://laravel.com/img/logotype.min.svg" alt="https://laravel.com/" width="110" />](https://laravel.com/)

---

[<img src="https://tailwindcss.com/_next/static/media/tailwindcss-logotype.128b6e12eb85d013bc9f80a917f57efe.svg"  width="200" />](https://tailwindcss.com/)

---

## Requirements

-   PHP 8 +
-   Laravel installer
-   Composer
-   Npm installer (Node.js ver. 14)
-   APACHE
-   PostgreSQL (ver 9)

## Installation

1. #### Clone the repository from GitHub and open the directory:

```
git clone https://github.com/keiwerkgvr/comextech-import.git
```

2. #### cd into your project directory

```
cd comextech-import
```

3. #### install composer and npm packages

```
composer install
npm install && npm run dev
```

## Start prepare the environment:

```
cp .env.example .env // setup database credentials
php artisan key:generate
php artisan migrate:refresh --seed
php artisan storage:link
```

## Run your server:

```
php artisan serve
npm run watch // observer webpack compliler (in develop)
```

Now, in this process you should get your API key, which will be the key to all of this. We put it in our Laravel projects .env file:

```
API_KEY_CURRENCY   = 

GOOGLE_MAPS_API_KEY= -

FEDEX_KEY = 
FEDEX_PASSWORD = 
FEDEX_ACCOUNT_NUMBER = .
FEDEX_METER_NUMBER = .
FEDEX_OAUTH_URL = https://apis-sandbox.fedex.com/oauth/token
FEDEX_RATE_URL = https://apis-sandbox.fedex.com/rate/v1/rates/quotes

DHL_SITEID = .
DHL_PASSWORD = .
DHL_ACCOUNT_NUMBER = .

DHL_EXP_SITEID = .
DHL_EXP_PASSWORD = .
DHL_EXP_ACCOUNT_NUMBER = .


AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=.
AWS_DEFAULT_REGION=sa-east-1
AWS_BUCKET=my-file-container-comextech
```

Warning again: As I mentioned, be extremely careful and not put that anywhere in the repository, cause you may get a bill for someone else ’s project. Or, better yet, restrict your API key by domain or some other method.

## Deploy project to Heroku:

```
heroku login
heroku git:remote -a comextech-import
git pull heroku master
git push heroku master
```

# Laravel 8.0+ Jetstream and Tailwind CSS Admin Theme

This project is created with [Laravel Jetstream] Framework and [Tailwind CSS](https://tailwindcss.com), the admin environment is desing by [Windmill Dashboard](https://windmill-dashboard.vercel.app/).

<img src="https://laravel.com/img/logotype.min.svg" width="110" />

---

<img src="https://tailwindcss.com/_next/static/media/tailwindcss-logotype.128b6e12eb85d013bc9f80a917f57efe.svg" width="200" />

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

1. #### cd into your project directory

```
cd comextech-import
```

1. #### install composer and npm packages

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
API_KEY_CURRENCY   = 816f5ba6a3a918f44402

GOOGLE_MAPS_API_KEY= AIzaSyB24kb-ImiN4VTuK0n4BtN-vX137CNEvtU

FEDEX_KEY = kN6FcXySl6Chr2Z0
FEDEX_PASSWORD = SttUWogpVE2kQ3xdbE7WrXDiv
FEDEX_ACCOUNT_NUMBER = 955761375
FEDEX_METER_NUMBER = 254271695
FEDEX_OAUTH_URL = https://apis-sandbox.fedex.com/oauth/token
FEDEX_RATE_URL = https://apis-sandbox.fedex.com/rate/v1/rates/quotes

DHL_SITEID = v62_RaycURsgUZ
DHL_PASSWORD = YYkBwXZmMm
DHL_ACCOUNT_NUMBER = 955653942

DHL_EXP_SITEID = v62_DZy8vS4koW
DHL_EXP_PASSWORD = I00uFsipN2
DHL_EXP_ACCOUNT_NUMBER = 673181996


AWS_ACCESS_KEY_ID=AKIAXLECW5WQNSO3O3FF
AWS_SECRET_ACCESS_KEY=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
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

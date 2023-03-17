## About Project

Task management project with some basic drag and drop functionality.

Library and Framwork used in this project

Framwork

-   Laravel
-   Vuejs with vite

Library

-   Quasar
-   axios
-   vuex

## Project Setup

Prerequest :

1. Composer
2. Node

step 1: install dependencies using follwing command

1.  composer install
2.  npm install

step 2: setup env file

1.  rename .env.example to .env
2.  put appropriate configuration to .env file for eg.

    -   APP_NAME=project_name

    -   APP_URL=http://localhost:8000
    -   VITE_BASE_URL=http://localhost:8000/api

    -   DB_CONNECTION=mysql
    -   DB_HOST=127.0.0.1
    -   DB_PORT=3306
    -   DB_DATABASE=database_name
    -   DB_USERNAME=database_username
    -   DB_PASSWORD=database_password

3.  hit command
    php artisan key:generate

step 2 : start laravel and vite server in terminal

-   php artisan serve (for laravel)
-   npm run dev (npm run dev for vue vite)

## migration and seed

hit following command to migrate and seed the data into users table

commands :

1. php artisan migrate
2. php artisan db:seed

some default users list after seeding data into users table

username : test@test.com
password : password

username : admin@admin.com
password : password

username : creator@creator.com
password : password

username : writer@writer.com
password : password

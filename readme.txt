1.
composer create-project laravel/laravel="5.7.*" .

2.
run npm install

3.
npm install admin-lte@v3.0.0-alpha.2 --save

4.
php artisan make:auth


5.
php artisan migrate

6.
Schema::defaultStringLength(191);

add this in AppserviceProvider.php boot() function
add import Schema at top
use Illuminate\Support\Facades\Schema;

7.create master.blade.php and paste the starter code in it.

8.
home.blade.php @extends('layouts.master')

9.
@import "~admin-lte/dist/css/adminlte.css"; 在app.scss中

10.
require("admin-lte"); 在bootstrap.js中

11.
run npm run watch

12.
install fontawesom by npm
npm install --save @fortawesome/fontawesome-free

$fa-font-path: "../webfonts";
Add this to app.scss中


@import "~@fortawesome/fontawesome-free/scss/fontawesome.scss";
@import "~@fortawesome/fontawesome-free/scss/solid.scss";
@import "~@fortawesome/fontawesome-free/scss/brands.scss";

Add those to app.scss中


13.
Install vue router
npm install vue-router

14.

Paste the code into app.js

14.
Output <router-view></router-view> in the master.blade.php main content area
add #app in the master.blade.php

15.
Change a link to router-link
change href to to

15.
error remove: add csrf token in the master.blade.php file

---- Useful Links ---
Icon Image:
https://www.flaticon.com/

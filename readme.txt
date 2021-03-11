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

16.
HTML5 History Mode Set Up
add history mode in app.js

const router = new VueRouter({
  mode: 'history',
  routes: [...]
})

17.
add regex in web.php

18.
set up logout in master page

php artisan route:list to see all routes

19.
Use v-form to handel form validation
https://github.com/cretueusebiu/vform

- run npm i axios vform
- import { Form, HasError, AlertError } from 'vform' in app.js
- register global components and form in app.js:
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form

-use it in component
add this into component script
    data() {
        return {
            form: new Form({
                name: "",
                email: "",
                password: "",
                type: "",
                bio: "",
                phone: ""
            })
        };
    },

two way bundle
<!-- name -->
<div class="form-group">
    <input
        placeholder="Name"
        v-model="form.name"
        type="text"
        name="name"
        class="form-control"
        :class="{
            'is-invalid': form.errors.has('name')
        }"
    />
    <has-error
        :form="form"
        field="name"
    ></has-error>
</div>

- add method
@submit.prevent="createUser" add it into form

methods: {
        createUser() {
            this.form.post("api/user");
        }
    },


-create controller api
php artisan make:controller API/UserController --api

-register API Resourses Routes in api.php
Route::apiResource('users', 'API\UserController');





Tips:
Set color in variables.css sass folder

click create btn and debug in chrome inspect/Network/XHR/Name/Headers ...

---- Useful Links & Resourses ---
Icon Image:
https://www.flaticon.com/

Laravel 5.6 restful partial resource routes
https://laravel.com/docs/5.6/controllers#restful-partial-resource-routes

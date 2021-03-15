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
Use v-form to handel form validation and can send request; Create and register API
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
            this.form.post("api/user").then(()=> {
                do next
            }).catch(()=> {

            });
        }
    },


-create controller api
php artisan make:controller API/UserController --api

-register API Resourses Routes in api.php
Route::apiResource('users', 'API\UserController');


20.
Server side form validation

add in controller:
$this->validate($request, [
    'name' => 'required|string|max:191',
    'email' => 'required|string|email|max:191|unique:users',
    password => 'required|string|min:6'
]);

21.
Get all users in the user.vue component

add in UserController index method
return User::latest()->paginate(10);

add in User.vue componend

- create empty users opject: users:{}
- add method loadUsers(){
    axios.get('api/user').then(({data}) => (this.users = data.data));
},

- use created() which is generally used for fetching data from backend API and setting it to data properties.
    created(){
        this.loadUsers();
    }
- use v-for in component
  <tr v-for="user in users" :key="user.id">
    <td>{{user.name}}</td>
  </tr>


22.
Use filter in vue
- use filter to make text first letter uppercase

- register the filter as global in app.js
    Vue.filter('upText', function(text){
        return text.charAt(0).toUpperCase() + text.slice(1);
    })

- use the filter in vue component
    {{user.type | upText}}


23.
Use momentjs to show readable time formate
- run npm i moment --save

- import it in app.js add
    import moment from 'moment';

- register it in app.js as global
    Vue.filter('myDate', function(created_at){
        return moment(created_at).format('MMMM Do YYYY')
    })

- use it in vue component
    {{user.created_at | myDate}}

24.
Use Progress Bar in Vue component

https://github.com/hilongjw/vue-progressbar

- npm install vue-progressbar
- import in app.js
    import VueProgressBar from 'vue-progressbar'
- Register it in app.js

    Vue.use(VueProgressBar, {
        color: 'rgb(143, 255, 199)',
        failedColor: 'red',
        height: '2px'
})

- Use it in template just under <router-view></router-view>
     <!-- set progressbar -->
    <vue-progress-bar></vue-progress-bar>

- Add start and finish method in the method of vue component
    start () {
        this.$Progress.start()
    },

     finish () {
        this.$Progress.finish()
    },

- add this.progress.fail() in catch block


25.
Use Sweet Alert
- npm install sweetalert2

- import and register it in app.js
    import swal from "sweetalert2";
    window.swal = swal;

- use toast which is show alert at the right top corner
    - Register toast in app.js
        add the code in app.js

        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

    - Register toast to window element in app.js
        window.toast = toast;

    - Use toast in vue component: add this code into next the action in component method
        toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
        })


26.
Close Modal when user created
- add $('#myModal').modal('hide') after the action and replace the modal ID

27.
Use Custom Vue Event to as a listener to send request

- add this in app.js to register globally Fire
    window.Fire = new Vue()
- use it in component
    add emit in function - emit is to create an event with a event name passed in it.
        Fire.$emit('AfterCreated');
    add $on in created() stage: - $on is to listen the event, and the below event can be listened in any component
        Fire.$on('AfterCreated', () => {
            this.loadUsers();
        })
- More advanced way is to use Pusher and Laravel echo???


28.
Delete User
- Add click event in vue component delete btn
    @click="deleteUser(user.id)"
- Add deleteUser Function in methods
    deleteUser(id){

    }

- Add sweetalert2 confirm information in the delete method first
- Add send delete request before show the delete successfully message
- Use Promist in the send request and add show delete successfully in then()
- In UserController delete method
    add $user = User::findOrFail($id);
    add $user->delete();
    add return ['message' => 'user deleted successfully'];


29.
Use one Modal for both add user and edit user
- firstlly, when add new user, reset all fields by using reset() method of Vue Form,
    add a method newModel to add user a tag without parameter, and without ()


- create function editModal(user) in edit a tag
- create editModal and receive user data
- use fill method to fill the user's data
    this.form.fill(user)


30.
Conditionally Switch Between Edit Mode and Create Mode of Modal Window
- Create editMode varible in data and set to false,
- editMode ? editUser() : createUser


31.
Update User
- add id to form: new Form({
    id = '';
})

- create updateUser() method
    updateUser(){
        this.$Progress.start();
        this.form.put('api/users/' + this.form.id).then(()=>{
            //success sweetalert2
            //close modal
            //progress bar finish
        }).catch(()=>{
            this.$Progress.fail();
        })
    },


- add code in UserController edit function
$user = User::findOrFail($id);
//validate
$this->validate($request,[
    'name' => 'required|string|max:191',
    'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
    'password' => 'sometimes|min:6'
]);

$user->update($request->all());
return ['message' => 'User Updated'];


32.
Security Issues While Developing API
- Install Laravel Passport for laravel 5.6
https://laravel.com/docs/5.6/passport#installation
    composer require laravel/passport
- use default migration
php artisan vendor:publish --tag=passport-migrations

- migrate
    php artisan migrate
- install passport
    php artisan passport:install

- use HasApiToken in user model
    use Laravel\Passport\HasApiTokens;
- add it into User class
    use HasApiTokens, Notifiable;

- call Passport::routes in boot method of AuthServiceProvider
    import Passport in to AuthServiceProvider
    Passport::routes();

-  set the driver option of the api authentication guard to passport.
    Location: config/auth.php

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],

- Publish some vue components for passport
    php artisan vendor:publish --tag=passport-components

33.
Consume API with JS

- add this into app/Http/Kernel.php file:
    'web' => [
    // Other middleware...
    \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
],

- add this into user controller
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**


34.
Create Profile component

- LTE admin 3 search widge/social widge
- LTE admin 3 search Pages / Profile / Settings Tab to find forms

35.
Populate Login User Infor Into Profile Form

- Create profile method in UserController
    public function profile(){
        return auth('api') -> user();
    }
- Register Route for Profile method
    Route::get('profile', 'API\UserController@profile')



Client ID: 1
Client secret: FIXgLuNmEgwKsrSM1PQJxMzyP9MN1C1z1aE5fcoO
Password grant client created successfully.
Client ID: 2
Client secret: RevxOxtYi83KcKVKeFx4y5r2pavBZGTRJzoYrFXO



36.
Upload image
- Add onchange function when upload file
    @change="updateProfile"
- add updateProfile function in component script methods object
      methods: {
        updateProfile(e) {
        let file = e.target.files[0];
        let reader = new FileReader();
        reader.onloadend = file => {
            console.log(123);
            console.log("RESULT", reader.result);
            this.form.photo = reader.result;
        };
        reader.readAsDataURL(file);
        }
  },


37.
Submit Base64 string to Server
- add @click.prevent="updateInfo" to update button

- add updateInfo in component with put axios
    updateInfo(){
        this.form.put('api/profile').then(() => {

        }).catch(()=>{

        })
    }


- add updateProfile put route in api.php file
    Route::put('profile', 'API\UserController@updateProfile');

- Create updateProfile method in UserController
    public function updateProfile(){
        //store current user in a variable
        $user = auth('api')->user;
    }


38.
Upload and Convert Base64 String to Image In PHP and Laravel
 - install php image intervention
    run php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"

 - take file extention, create file name and save in Server
        if ($request->photo) {
        $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('img/profile/' . $name));
    }

39.
Check file size before uploading

40.
Save Info
- Check if photo has changed in UserController profile method
    $currentPhoto = $user->photo;
    if($request->photo != $currentPhoto){

    }

     $user->update($request->all());
- Use Merge to change the request field name
- Validate input information in UserController
        //validate
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6'
        ]);

- Check if password has been changed and hash it

    if(!empty($request->password)){
        $request->merge(['password' => Hash::make($request['password'])]);
    }
    $user->update($request->all());

- Handle error in profile forms
    - Add this in input field
        :class="{
    'is-invalid': form.errors.has('name')}"
    - Add this behind input field
         <has-error
            :form="form"
            field="name"
        ></has-error>


41.
Delete old photo from Server by using @unlink
    $userPhoto = public_path('img/profile/).$currentPhoto;
    if(file_exists($userPhoto)){
        @unlink($userPhoto);
    }

42.
Display image from server in Vue

- Add getImage function and bind it with image src
    :src="userPhoto"
- Create the function
    getProfileImage(){
        return 'img/profile/' + this.form.photo;
    }

-43.
Apply access control for users
- Add gate in AuthServiceProvider.php
     public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('isAdmin', function ($user) {
            return $user->type == 'admin';
        });

        $gate->define('isUser', function ($user) {
            return $user->type == 'user';
        });

        $gate->define('isOrganization', function ($user) {
            return $user->type == 'organization';
        });

        $gate->define('isMyAccount', function ($user, $profileUser) {
            return $user->id === $profileUser->id;
        });

        Passport::routes();
    }






Tips:
Set color in variables.css sass folder

click create btn and debug in chrome inspect/Network/XHR/Name/Headers ...

- run php artisan route:list to see all endpoints.

---- Useful Links & Resourses ---
Icon Image:
https://www.flaticon.com/

Laravel 5.6 restful partial resource routes
https://laravel.com/docs/5.6/controllers#restful-partial-resource-routes

Vue filter docs
https://vuejs.org/v2/guide/filters.html

momentjs - to make date more readable
https://momentjs.com/
https://momentjs.com/docs/#/displaying/

Vue js Progress Bar
https://github.com/hilongjw/vue-progressbar
http://hilongjw.github.io/vue-progressbar/index.html  -- Demo


SweetAlert2
https://sweetalert2.github.io/

Debug sending request in chrom inspect

Arrow function
it can use this.xx inside it.

Laravel Passport docs
https://laravel.com/docs/5.6/passport#installation


How can I convert an image into Base64 string using JavaScript?(use approach three)
https://stackoverflow.com/questions/6150289/how-can-i-convert-an-image-into-base64-string-using-javascript

PHP Image Intervention
http://image.intervention.io/


Solve Composer Memory Limit error
sudo php -d memory_limit=-1 /usr/local/bin/composer install
https://github.com/invoiceninja/invoiceninja/issues/60
https://stackoverflow.com/questions/36107400/composer-update-memory-limit

Vue input file clear
https://codepen.io/Pratik__007/pen/MWYVjqP?editors=1010

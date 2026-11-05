<?php

use Laravel\Fortify\Features;

return [

    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'password' => 'password',

    'email' => 'correo',


    'lowercase_usernames' => true,

    'home' => '/home',

    'prefix' => '',

    'domain' => null,

    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'views' => true,

    'features' => [
        Features::registration(),

        Features::resetPasswords(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
    ],

];

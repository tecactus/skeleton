<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Skeleton Configuration
    |--------------------------------------------------------------------------
    |
    | //
    |
    */

    'autoload' => [
        'providers' => true,
        'aliases' => true,
    ],

    'enable_activations' => false,

    /*
    |--------------------------------------------------------------------------
    | Skeleton Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and account
    | activation options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'activations' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Account Activation
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for activating accounts. You may also set
    | the name of the table that maintains all of the activation tokens for your
    |  application.
    |
    | You may specify multiple account activation configurations if you have more
    | than one user table or model in the application and you want to have
    | separate account activation settings based on the specific user types.
    |
    | The expire time is the number of days that the activation token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */
   
    'activations' => [
        'users' => [
            'provider' => 'users',
            'table' => 'account_activations',
            'expire' => 7,
        ],
    ],

];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Global defaults
    |--------------------------------------------------------------------------
    |
    | This package makes a few assumptions for initial global settings.
    | Edit these values if you want the global defaults to be different.
    |
    */

    'defaults' => [
        'style' => 'link-primary',
        'loadingStyle' => 'link-grey',
        'loadingText' => 'Loading',
        'successStyle' => 'link-success',
        'successText' => 'Success',
        'errorStyle' => 'link-danger',
        'errorText' => 'Failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Style options
    |--------------------------------------------------------------------------
    |
    | These styles are all the styles that can be used in the frontend. You are
    | free to add, edit or delete to your likings.
    |
    | The CSS classes below come from Tailwind CSS, which is shipped with Nova.
    |
    */

    'styles' => [
        // Fill
        'primary' => 'cursor-pointer btn btn-default btn-primary',
        'success' => 'cursor-pointer btn btn-default bg-success text-white',
        'warning' => 'cursor-pointer btn btn-default bg-warning text-white',
        'danger' => 'cursor-pointer btn btn-default bg-danger text-white',
        'info' => 'cursor-pointer btn btn-default bg-info text-white',
        'grey' => 'cursor-pointer btn btn-default bg-60 text-white',

        // Outline
        'primary-outline' => 'cursor-pointer btn btn-default border border-primary text-primary',
        'success-outline' => 'cursor-pointer btn btn-default border border-success text-success',
        'warning-outline' => 'cursor-pointer btn btn-default border border-warning text-warning ',
        'danger-outline' => 'cursor-pointer btn btn-default border border-danger text-danger ',
        'info-outline' => 'cursor-pointer btn btn-default border border-info text-info ',
        'grey-outline' => 'cursor-pointer btn btn-default border border-60 text-80 ',

        // Link
        'primary-link' => 'cursor-pointer dim inline-block text-primary font-bold btn btn-link',
        'success-link' => 'cursor-pointer dim inline-block text-success font-bold btn btn-link',
        'warning-link' => 'cursor-pointer dim inline-block text-warning font-bold btn btn-link',
        'danger-link' => 'cursor-pointer dim inline-block text-danger font-bold btn btn-link',
        'info-link' => 'cursor-pointer dim inline-block text-info font-bold btn btn-link',
        'grey-link' => 'cursor-pointer dim inline-block text-80 font-bold btn btn-link',

        // Custom
        'custom' => 'bg-orange',
    ],

];

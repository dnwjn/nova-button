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
        'loadingStyle' => 'link-gray',
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
        'primary' => 'cursor-pointer rounded px-4 h-9 font-bold bg-primary-500 hover:bg-primary-400 text-black',
        'success' => 'cursor-pointer rounded px-4 h-9 font-bold bg-green-500 hover:bg-green-400 text-white',
        'warning' => 'cursor-pointer rounded px-4 h-9 font-bold bg-yellow-500 hover:bg-yellow-400 text-white',
        'danger' => 'cursor-pointer rounded px-4 h-9 font-bold bg-red-500 hover:bg-red-400 text-white',
        'info' => 'cursor-pointer rounded px-4 h-9 font-bold bg-blue-500 hover:bg-blue-400 text-white',
        'gray' => 'cursor-pointer rounded px-4 h-9 font-bold bg-gray-500 hover:bg-gray-400 text-white',

        // Outline
        'primary-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-primary-500 hover:bg-primary-400 text-black border-2',
        'success-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-green-500 hover:bg-green-400 text-white border-2',
        'warning-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-yellow-500 hover:bg-yellow-400 text-white border-2',
        'danger-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-red-500 hover:bg-red-400 text-white border-2',
        'info-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-blue-500 hover:bg-blue-400 text-white border-2',
        'gray-outline' => 'cursor-pointer rounded px-4 h-9 font-bold bg-gray-500 hover:bg-gray-400 text-white border-2',

        // Link
        'primary-link' => 'cursor-pointer dim inline-block font-bold text-primary-500 hover:text-primary-400',
        'success-link' => 'cursor-pointer dim inline-block font-bold text-green-500 hover:text-green-400',
        'warning-link' => 'cursor-pointer dim inline-block font-bold text-yellow-500 hover:text-yellow-400',
        'danger-link' => 'cursor-pointer dim inline-block font-bold text-red-500 hover:text-red-400',
        'info-link' => 'cursor-pointer dim inline-block font-bold text-blue-500 hover:text-blue-400',
        'gray-link' => 'cursor-pointer dim inline-block font-bold text-gray-500 hover:text-gray-400',

        // Custom
        'custom' => 'bg-orange-500 hover:bg-orange-400',
    ],

];

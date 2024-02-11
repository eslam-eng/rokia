<?php

return [

    /*
    |--------------------------------------------------------------------------
    | permissions that compnay choose when create his users
    |--------------------------------------------------------------------------
    |
    */

    'therapists' => [
        'create_therapist',
        'edit_therapist',
        'delete_therapist',
        'change_therapist_status',
    ],

    'sliders' => [
        'create_slider',
        'edit_slider',
        'delete_slider',
    ],

    'categories' => [
        'create_category',
        'edit_category',
        'delete_category',
    ],

    'rozmana' => [
        'view_rozmana',
    ],

    'clients' => [
        'view_clients',
    ],

    'users' => [
        'create_users',
        'edit_users',
        'delete_users',
    ],

    'roles' => [
        'create_role',
        'edit_role',
        'delete_role',
    ],

];

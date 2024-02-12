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
        'list_slider',
        'create_slider',
        'edit_slider',
        'delete_slider',
        'change_slider_status',
    ],

    'categories' => [
        'list_category',
        'create_category',
        'edit_category',
        'delete_category',
        'change_category_status',
    ],

    'rozmana' => [
        'list_rozmana',
    ],

    'clients' => [
        'list_clients',
    ],

    'users' => [
        'list_users',
        'create_users',
        'edit_users',
        'delete_users',
        'change_users_status',
    ],

    'roles' => [
        'list_role',
        'create_role',
        'edit_role',
        'delete_role',
    ],

];

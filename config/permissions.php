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

    'interests' => [
        'list_interests',
        'create_interest',
        'edit_interest',
        'delete_interest',
        'change_interest_status',
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

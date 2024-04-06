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
        'list_therapists',
        'edit_therapist',
        'delete_therapist',
        'change_therapist_status',
        'show_schedules',
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
        'change_client_status',
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
    'appointments' => [
        'list_appointment',
    ],
    'settings' => [
        'show_setting',
    ],

    'specialists' => [
        'list_specialists',
        'create_specialist',
        'edit_specialist',
        'delete_specialist',
        'change_specialists_status',
    ],
    'lectures' => [
        'lecture_report',
        'list_lectures',
        'edit_lectures',
        'delete_lectures',
        'change_image_cover',
        'change_lectures_status',
    ],
    'invoices' => [
        'list_invoices',
        'change_invoices_status',
        'add_therapist_Invoice'
    ],

    'plan' => [
        'show_plan',
    ],

];

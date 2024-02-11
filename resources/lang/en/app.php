<?php

return [

    /*
    |--------------------------------------------------------------------------
    | all app Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during
    */

    'dashboard' => [
        'dashboard_title' => 'Dashboard',
        'users_count' => 'Users Count',
        'active_lectures' => 'Active Lectures',
        'not_active_lectures' => 'Not Active Lectures',
        'paid_lectures' => 'Paid Lectures',
        'free_lectures' => 'Free Lectures',
        'recently_lectures' => 'Recently Lectures',
        'upcoming_lectures' => 'Upcoming Lectures',

    ],

    'auth' => [
        'login_failed' => 'invalid credential',
        'auth_in_review' => 'Your data is being reviewed. You can try again later',
        'email_or_phone' => 'Email/Phone',
        'password' => 'Password',
        'please_login_to_continue' => 'Please sign in to continue.',
        'sign_in' => 'Sign in',
        'welcome_back' => 'Welcome Back',
    ],
    'general' => [
        'PENDING' => 'Pending',
        'ACTIVE' => 'Active',
        'INACTIVE' => 'Inactive',
        'select_status' => 'choose status...',
        'select_type' => 'choose type...',
        'select_gender' => 'choose gender...',
        'male' => 'Male',
        'female' => 'Female',
        'MALE' => 'Male',
        'FEMALE' => 'Female',
        'reset' => 'Reset',
        'are_u_sure' => 'Are you sure?',
        'change_status_to' => 'Change Status To :status',
        'swal_confirm_btn' => 'Yes',
        'created_at' => 'Created At',
        'action' => 'Action',
        'gender' => 'Gender',
        'search' => 'Search',
        'save' => 'Save',
        'back' => 'Back',
        'filters' => 'Filters',
        'status' => 'Status',
        'no_data_available' => 'No data available',
    ],


    'lectures' => [
        'lectures' => 'Lectures',
        'all_lectures' => 'All Lectures',
        'title' => 'Title',
        'description' => 'Description',
        'price' => 'Price',
        'is_paid' => 'Is Paid',
        'therapist' => 'Therapist',
        'users_subscription' => 'Users Subscription',
        'status' => 'Status',
        'paid' => 'Paid',
        'free' => 'Free',
        'lectures_page_title' => 'Lectures',
        'lectures_filter' => 'Lectures Filter',
        'lectures_count' => 'Lectures Count',
        'upcoming_lectures' => 'UpComing Lectures',
        'edit_lecture' => 'Lecture Edit',
        'lecture_title' => 'Lecture Title',
        'lecture_upload_success' => 'Lecture Uploaded Successfully',

    ],

    'therapists' => [
        'therapists' => 'Therapists',
        'therapist' => 'Therapist',
        'all_therapists' => 'All Therapists',
        'therapist_page_title' => 'therapists',
        'therapist_filter' => 'Therapists Filter',
        'name' => 'Name',
        'phone' => 'Phone',
        'address' => 'Address',
        'email' => 'Email',
        'gender' => 'Gender',
        'therapist_commission' => 'Therapists commission',
        'add_therapist' => 'Add Therapists',
        'status' => 'Status',

    ],

    'clients' => [
        'users_page_title' => 'Clients',
        'all_clients' => 'All Clients',
        'clients' => 'Clients',
        'name' => 'Name',
        'phone' => 'Phone',
        'address' => 'Address',
        'email' => 'Email',
        'gender' => 'Gender',
        'lecture_count' => 'Lecture Count',
        'status' => 'status',
        'status_changed_successfully' => 'Status Changed Successfully',
        'not_found' => 'User Not Found',
    ],

    'invoices' => [
        'invoices' => 'Invoices',
        'invoice_page_title' => 'Invoices',
        'all_invoices' => 'All Invoices',
        'status' => 'status',
        'sub_total' => 'Subtotal',
        'therapist_due' => 'Therapist Due',
        'grand_total' => 'Grand total',
        'items_count' => 'Items Count',
        'PENDING' => 'Pending',
        'Completed' => 'Completed',
        'complete' => 'Complete',

    ],
    'sliders' => [
        'title' => 'Sliders',
        'add_slider' => 'Add Slider',
        'image' => 'image',
        'caption' => 'caption',
        'order' => 'order',
        'status' => 'status',
    ],
    'categories' => [
        'title' => 'Categories',
        'name' => 'name',
        'add_category' => 'Add Category',
        'edit_category' => 'edit Category',
        'status' => 'status',
        'status_changed_successfully' => 'Status Changed Successfully',
        'category_not_found' => 'Category Not Found',
    ],
    'rozmana' => [
        'title' => 'title',
        'rozmana_title' => 'Rozmana',
        'rozmana_created_successfully' => 'Rozmana Created Successfully',
        'rozmana_updated_successfully' => 'Rozmana Updated Successfully',
        'rozmana_not_fount' => 'Rozmana Not Found',
        'rozmana_deleted_successfully' => 'Rozmana Deleted Successfully',
        'status' => 'status',
        'date' => 'date',
        'description' => 'Description',
        'thereapist' => 'Therapist',
    ],

    'lecture_report' => [
        'title' => 'Lecture Report',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
    ],
    'select2' => [
        'no_results' => 'No Results found',
        'searching' => 'Searching...',
        'input_too_short' => 'please Write more than 2 characters',
    ],
    'system' => [
        'title' => 'System',
        'role_name' => 'Role Name',
        'add_role' => 'Add Role',
        'roles'=>'Roles',
        'roles_and_permissions'=>'Roles And Permissions',
        'users_count'=>'Users Count',
        'permissions_count'=>'Permissions Count',
        'users_list' => 'Users List',
        'add_user' => 'Add User',
        'edit_user' => 'Edit User',

        'permissions'=>[
            'therapists' => [
                'title'=>'Therapists',
                'create_therapist'=>'Create Therapist',
                'edit_therapist'=>'Edit Therapist',
                'delete_therapist'=>'Delete Therapist',
                'change_therapist_status'=>'Change Therapist Status',
            ],

            'sliders' => [
                'title'=>'Sliders',
                'create_slider'=>'Create Slider',
                'edit_slider'=>'Edit Slider',
                'delete_slider'=>'Delete Slider',
            ],

            'categories' => [
                'title'=>'Categories',
                'create_category'=>'Create Category',
                'edit_category'=>'Edit Category',
                'delete_category'=>'Delete Category',
            ],

            'rozmana' => [
                'title'=>'Rozmana',
                'view_rozmana'=>'View Rozmana',
            ],

            'clients' => [
                'title'=>'Clients',
                'view_clients'=>'View Clients',
            ],

            'users' => [
                'title'=>'Users',
                'create_users'=>'Create Users',
                'edit_users'=>'Edit Users',
                'delete_users'=>'Delete Users',
            ],

            'roles' => [
                'title'=>'Roles',
                'create_role'=>'Create Role',
                'edit_role'=>'Edit Role',
                'delete_role'=>'Delete Role',
            ],
        ],
    ],

];

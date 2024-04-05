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
        'success_operation' => 'Success Operation',
        'invaild_inputs' => 'Invaild Inputs',
        'there_is_an_error' => 'There is an Error',
    ],

    'week_days' => [
        'SUNDAY' => 'Sunday',
        'MONDAY' => 'Monday',
        'TUESDAY' => 'Tuesday',
        'WEDNESDAY' => 'Wednesday',
        'THURSDAY' => 'Thursday',
        'FRIDDAY' => 'Friday',
        'SATURDAY' => 'Saturday'
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
        'duration'=>'duration',
        'created_at'=>'Created At',
        'publish_date'=>'Publish Date',
        'lectures_page_title' => 'Lectures',
        'lectures_filter' => 'Lectures Filter',
        'lectures_count' => 'Lectures Count',
        'upcoming_lectures' => 'UpComing Lectures',
        'edit_lecture' => 'Lecture Edit',
        'lecture_title' => 'Lecture Title',
        'lecture_upload_success' => 'Lecture Uploaded Successfully',
        'recorded_lecture' => 'Recorded lecture',
        'live_lecture' => 'Live lecture',

    ],

    'therapists' => [
        'therapists' => 'Therapists',
        'search_therapists' => 'Search Therapists...',
        'therapist' => 'Therapist',
        'all_therapists' => 'All Therapists',
        'therapist_page_title' => 'therapists',
        'therapist_filter' => 'Therapists Filter',
        'name' => 'Name',
        'phone' => 'Phone',
        'address' => 'Address',
        'email' => 'Email',
        'password' => 'Password',
        'gender' => 'Gender',
        'therapist_commission' => 'Therapists commission',
        'add_therapist' => 'Add Therapists',
        'status' => 'Status',
        'documets'=>'Documents',
        'edit'=>'Edit',
        'deactive'=>'Deactivate',
        'activate'=>'Activate',
        'delete'=>'Delete',
        'schedules'=>[
            'title'=>'Schedules',
            'day_name'=>'Day',
            'time_from'=>'Time Form',
            'time_to'=>'Time To',
            'to'=>' To ',
            'therapist_schedule_exception_profile_data_not_completed'=>'Please make sure you set time and price for therapy session',
        ],
        'avg_therapy_duration'=>'avg therapy duration(in minutes)'

    ],
    'therapist_plan'=>[
      'title'=>'Therapist Plans',
      'name'=>'Name',
      'duration'=>'Duration (days)',
      'price'=>'Price',
      'status'=>'Price',
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

        'invoice_items'=>[
          'buy_lecture'=>'Buy Lecture',
          'plan_subscription'=>'Plan Subscription',
          'book_appointment'=>'Book Appointment',
        ],

    ],
    'appointments' => [
        'title' => 'Appointments',
        'appointments_list' => 'Appointments List',
        'price' => 'Price',
        'user_description' => 'User Description',
        'day' => 'Day',
        'date' => 'Date',
        'status' => 'status',
        'therapist_name' => 'Therapist',
        'client_name' => 'Client',
        'pending'=>'Pending',
        'waiting_for_paid'=>'Waiting For Paid',
        'approved'=>'Approved(waiting for pay)',
        'compeleted'=>'Compeleted',
        'appointment_notification_title'=>'Appointment Number # :number',
        'appointment_notification_body'=>'Appointment Status Changet To :status',
        'appointment_status_change_exception'=>'Cannot Change Status Appointment Status already :status',

    ],
    'sliders' => [
        'title' => 'Sliders',
        'add_slider' => 'Add Slider',
        'image' => 'image',
        'caption' => 'caption',
        'order' => 'order',
        'status' => 'status',
    ],
    'plans' => [
        'title' => 'Plans',
        'plans_list' => 'Plans List',
        'add_plan' => 'Add Plan',
        'name' => 'Name',
        'duration' => 'Duraion',
        'price' => 'Price',
        'status' => 'Status',
        'plan_not_found' => 'Plan Not Found',
    ],
    'users' => [
        'title' => 'Users',
        'users_list' => 'Users List',
        'name' => 'name',
        'email' => 'email',
        'phone' => 'phone',
        'password' => 'pasword',
        'gender' => 'gender',
        'status' => 'gender',
        'address' => 'address',
        'choose_gender' => 'choose gender...',
        'choose_role' => 'choose role...',
        'role' => 'role',
        'add_user' => 'Add User',
        'edit_user' => 'Edit User',

    ],
    'interests' => [
        'title' => 'Interests',
        'name' => 'name',
        'add_interest' => 'Add Interest',
        'edit_interest' => 'edit Interest',
        'status' => 'status',
        'status_changed_successfully' => 'Status Changed Successfully',
        'interest_not_found' => 'Interest Not Found',
    ],
    'specialist' => [
        'title' => 'Specialists',
        'name' => 'name',
        'add_specialist' => 'Add Specialist',
        'edit_specialist' => 'Edit',
        'delete_specialist' => 'Delete',
        'status' => 'status',
        'change_status' => 'Change status',
        'status_changed_successfully' => 'Status Changed Successfully',
        'specialist_not_found' => 'Category Not Found',
    ],
    'rozmana' => [
        'title' => 'title',
        'rozmana_title' => 'Rozmana',
        'rozmana_count' => 'Rozmana Count',
        'rozmana_details' => 'Rozmana Details',
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
    'settings' => [
        'title' => 'Settings',
        'general_settings' => 'General Settings',
        'about_us'=>'About Us',
        'privacy'=>'Privacy&Conditions',
        'support_phone'=>'Support Phone',

    ],
    'system' => [
        'title' => 'System',
        'role_name' => 'Role Name',
        'add_role' => 'Add Role',
        'roles' => 'Roles',
        'roles_and_permissions' => 'Roles And Permissions',
        'users_count' => 'Users Count',
        'permissions_count' => 'Permissions Count',
        'users_list' => 'Users List',
        'add_user' => 'Add User',
        'edit_user' => 'Edit User',

        'permissions' => [
            'therapists' => [
                'title' => 'Therapists',
                'create_therapist' => 'Create Therapist',
                'edit_therapist' => 'Edit Therapist',
                'delete_therapist' => 'Delete Therapist',
                'change_therapist_status' => 'Change Therapist Status',
            ],

            'sliders' => [
                'title' => 'Sliders',
                "list_slider"=> "View Slider",
                'create_slider' => 'Create Slider',
                'edit_slider' => 'Edit Slider',
                'delete_slider' => 'Delete Slider',
            ],

            'interests' => [
                'title' => 'interests',
                'create_interest' => 'Create Interest',
                'edit_interest' => 'Edit Interest',
                'delete_interest' => 'Delete Interest',
                'change_interest_status' => 'Change Interest Status',
                "list_interests"=> "View interests"
            ],

            'rozmana' => [
                'title' => 'Rozmana',
                'list_rozmana' => 'View Rozmana',
            ],

            'clients' => [
                'title' => 'Clients',
                'list_clients' => 'View Clients',
                "change_client_status"=> 'Change Status'
            ],

            'users' => [
                'title' => 'Users',
                'create_users' => 'Create Users',
                'edit_users' => 'Edit Users',
                'delete_users' => 'Delete Users',
                "list_users"=> "View Users"
            ],

            'roles' => [
                'title' => 'Roles',
                'create_role' => 'Create Role',
                'edit_role' => 'Edit Role',
                'delete_role' => 'Delete Role',
            ],
            'appointments' => [
                'title' => "Appointments",
                'list_appointment'=> 'View Appointments',
            ],
            'settings' => [
                'title' => "Settings",
                'show_setting' => 'Show Setting',
            ],
            'specialists' => [
                'title' => "Specialists",
                'list_specialists'=> "View Specialists",
                'create_specialist'=> 'Create Specialist',
                'edit_specialist'=> 'Edit Specialist',
                'delete_specialist'=> 'Delete Specialist',
                'change_specialists_status'=> 'Change Status',
            ],
            'lectures' => [
                'title' => "Lectures",
                'lecture_report'=> 'Lecture Report',
                'list_lectures'=> 'View Lectures',
                'edit_lectures'=> 'Edit Lectures',
                'delete_lectures'=> 'Delete Lectures',
                'change_image_cover'=> 'Change Image Cover',
                'change_lectures_status'=> 'Change Status',
            ],
            'invoices' => [
                'title' => "Invoices",
                'list_invoices'=> 'List Invoices',
                'change_invoices_status'=> 'Change Status',
                'add_therapist_Invoice'=> 'Add Therapist Invoice'
            ],

            'plane' => [
                'title' => "Plane",
                'show_plane', 'View Plane'
            ],
        ],
    ],

];

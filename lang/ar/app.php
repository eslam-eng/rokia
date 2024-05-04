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
        'dashboard_title' => 'الرئيسية',
        'users_count' => 'عدد المستخدمين',
        'active_lectures' => 'المحاضرات النشطة',
        'not_active_lectures' => 'المحاضرات الغير نشطة',
        'paid_lectures' => 'المحاضرات المدفوعة',
        'free_lectures' => 'المحاضرات المجانية',
        'recently_lectures' => 'المضاف حديثا',
        'upcoming_lectures' => 'المحاضرات القادمة',
        'users_count_statistics' => 'إحصائيات المستخدمين',
        'sales_statistics' => 'إحصائيات البيع',
        'therapists_and_plans'=>"المعالجين & خطط الاسعار",
        'interests_and_specialists'=>"الاهتمامات & التخصصات"
    ],

    'auth'=>[
        'login_failed'=>'بيانات الدخول غير صحيحة',
        'email_or_phone'=>'رقم التليفون/البريد الالكتروني',
        'password'=>'كلمة المرور',
        'please_login_to_continue'=>'من فضلك سجل دخولك للمتابعة.',
        'sign_in'=>'تسجيل الدخول',
        'welcome_back'=>'مرحبًا بعودتك',
        'auth_in_review' => 'سوف يتم مراجعة البيانات,والرد في اقرب وقت',

    ],
    'general' => [
        'PENDING' => 'معلقة',
        'ACTIVE' => 'نشط',
        'INACTIVE' => 'غير نشط',
        'select_status' => 'اختر حالة...',
        'select_type' => 'اختر النوع ...',
        'select_gender' => 'اختر الجنس...',
        'male' => 'ذكر',
        'female' => 'انثي',
        'MALE' => 'ذكر',
        'FEMALE' => 'انثي',
        'reset' => 'إعادة تعيين',
        'are_u_sure' => 'هل انت متأكد؟',
        'change_status_to' => 'تغيير الحالة إلى :status',
        'swal_confirm_btn' => 'نعم',
        'created_at' => 'تاريخ الانشاء',
        'action' => 'الاجراء',
        'gender' => 'الجنس',
        'search' => 'بحث',
        'save' => 'حفظ',
        'back' => 'رجوع',
        'filters' => 'تصفية',
        'no_data_available' => 'لا يوجد سجلات',
        'status' => 'الحالة',

    ],
    'week_days' => [
        'SUNDAY' => 'الاحد',
        'MONDAY' => 'الاثنين',
        'TUESDAY' => 'الثلاثاء',
        'WEDNESDAY' => 'الاربعاء',
        'THURSDAY' => 'الخميس',
        'FRIDDAY' => 'الجمعة',
        'SATURDAY' => 'السبت'
    ],


    'lectures' => [
        'lectures' => 'المحاضرات',
        'all_lectures' => 'كل المحاضرات',
        'title' => 'العنوان',
        'description' => 'الوصف',
        'price' => 'السعر',
        'is_paid' => 'مدفوع؟',
        'therapist' => 'الشيخ',
        'users_subscription' => 'اشتراك المستخدمين',
        'status' => 'الحالة',
        'paid' => 'مدفوع',
        'free' => 'مجاني',
        'lectures_page_title' => 'المحاضرات',
        'lectures_filter' => 'تصفية المحاضرات',
        'lectures_count' => 'عدد المحاضرات',
        'upcoming_lectures' => 'المحاضرات القادمة',
        'edit_lecture' => 'تعديل المحاضرة',
        'lecture_title' => 'عنوان المحاضرة',

        'lecture_upload_success' => 'تم رفع المحاضرة بنجاح',

    ],

    'therapists' => [
        'profile' => "الملف الشخصي",
        'therapist_accounting' => "حسابات الشيخ",
        'therapists' => 'المعالجين',
        'therapist' => 'المعالج',
        'all_therapists' => 'كل المعالجين',
        'therapist_page_title' => 'المعالجين',
        'therapist_filter' => 'تصفية المعالجين',
        'name' => 'الاسم',
        'phone' => 'رقم التليفون',
        'address' => 'العنوان',
        'email' => 'البريد الالكترروني',
        'gender' => 'الجنس',
        'therapist_commission' => 'عمولة المعالجين',
        'add_therapist' => 'اضافة معالج',
        'status' => 'الحالة',

        'search_therapists' => 'بحث في المعالجين...',
        'password' => 'كلمة المرور',
        'documets'=>'الوثائق',
        'edit'=>'تعديل',
        'deactive'=>'غير مفعل',
        'activate'=>'مفعل',
        'delete'=>'حذف',
        'schedules'=>[
            'title'=>'الجدول الزمني',
            'day_name'=>'اليوم',
            'time_from'=>'الوقت من',
            'time_to'=>'الوقت الي',
            'to'=>' ألي ',
            'therapist_schedule_exception_profile_data_not_completed'=>'يرجى التأكد من تحديد الوقت والسعر لجلسة العلاج',
        ],
        'avg_therapy_duration'=>'متوسط مدة العلاج (بالدقائق)'

    ],

    'therapist_plan'=>[
        'title'=>'خطط الاسعار',
        'name'=>'الاسم',
        'duration'=>'المدة(ايام)',
        'price'=>'السعر',
        'status'=>'الحالة',
    ],

    'clients' => [
        'users_page_title' => 'العملاء',
        'all_clients' => 'كل العملاء',
        'clients' => 'العملاء',
        'name' => 'الاسم',
        'phone' => 'التليفون',
        'address' => 'العنوان',
        'email' => 'البريد الالكتروني',
        'gender' => 'الجنس',
        'lecture_count' => 'عدد المحاضرات',
        'status' => 'الحالة',

        'status_changed_successfully' => 'تم تغير الحالة بنجاح',
        'not_found' => 'المتسخدم غير موجود',
    ],

    'invoices' => [
        'invoices' => 'الفواتير',
        'invoice_page_title' => 'الفواتير',
        'all_invoices' => 'كل الفواتير',
        'status' => 'الحالة',
        'sub_total'=>'الاجمالي',
        'therapist_due'=>'مستحقات المعالج',
        'grand_total'=>'الصافي',
        'items_count'=>'Items Count',

        'PENDING' => 'معلقة',
        'Completed' => 'مكتملة',
        'complete' => 'تم الاكتمال',
        'complete_date' => 'تاريخ الاكتمال',

        'invoice_items' => [
            'buy_lecture' => 'شراء محاضرة',
            'plan_subscription' => 'اشتراك رزنامة',
            'book_appointment' => 'حجز استشارة خاصة',
            'type' => 'النوع',
            'item_details'=>'تفاصيل الفاتورة',
            'price'=>'السعر',
            'date'=>'التاريخ',
            'time'=>'الوقت',
            'title'=>'العنوان',
            'duration'=>'المده',
        ],
    ],

    'appointments' => [
        'title' => 'الحجوزات',
        'appointments_list' => 'قائمة الحجوزات',
        'price' => 'السعر',
        'user_description' => 'الوصف',
        'day' => 'اليوم',
        'date' => 'تاريخ',
        'status' => 'الحالة',
        'therapist_name' => 'المعالج',
        'client_name' => 'العميل',
        'pending'=>'معلقه',
        'waiting_for_paid'=>'تم الموافقة(منتظر الدفع)',
        'approved'=>'تم الموافقة(منتظر الدفع)',
        'completed'=>'مكتمل',
        'canceled'=>'ملغي',
        'appointment_notification_title'=>'الحجز رقم  # :number',
        'appointment_notification_body'=>'تم تغير حالة الحجز الي :status',
        'appointment_status_change_exception'=>'لا يمكن تغير الحالة , حالة الحجز  :status',

    ],

    'sliders' => [
        'title' => 'شريط السحب',
        'add_slider' => 'اضافة',
        'image' => 'الصوره',
        'caption' => 'الوصف',
        'order' => 'الترتيب',
        'status' => 'الحالة',
    ],

    'users' => [
        'title' => 'المتستخدمين',
        'users_list' => 'قائمه المستخدمين',
        'name' => 'الاسم',
        'email' => 'البريد الالكتروني',
        'phone' => 'التليفون',
        'password' => 'كلمه المرور',
        'gender' => 'النوع',
        'status' => 'الحالة',
        'address' => 'العنوان',
        'choose_gender' => 'اختر النوع...',
        'choose_role' => 'اختر الدور...',
        'role' => 'الدور',
        'add_user' => 'اضافة مستخدم',
        'edit_user' => 'تعديل مستخدم',

    ],

    'interests' => [
        'title' => 'الفئات /الاهتمامات',
        'name' => 'الاسم',
        'add_interest' => 'اضافة فئه/اهتمام',
        'edit_interest' => 'تعديل',
        'status' => 'الحالة',
        'status_changed_successfully' => 'تم تغير الحالة بنجاح',
        'interest_not_found' => 'غير موجود',
    ],

    'specialist' => [
        'title' => 'التخصصات',
        'name' => 'الاسم',
        'add_specialist' => 'إضافة تخصص',
        'edit_specialist' => 'تعديل',
        'delete_specialist' => 'حذف',
        'status' => 'الحالة',
        'change_status' => 'تغير الحالة',
        'status_changed_successfully' => 'تم تغير الحالة بنجاح',
        'specialist_not_found' => 'التخصص غير موجود',
    ],
    'plans' => [
        'title' => 'خطط الاسعار',
        'plans_list' => 'قائمة خطط الاسعار',
        'add_plan' => 'إضافة',
        'name' => 'الاسم',
        'duration' => 'المدة',
        'price' => 'السعر',
        'status' => 'الحالة',
        'plan_not_found' => 'غير موجودة',
    ],
    'rozmana' => [
        'title' => 'الاشعارات اليوميه',
        'rozmana_title' => 'الاشعارات اليوميه',
        'status' => 'الحالة',
        'date' => 'التاريخ',
        'description' => 'الوصف',
        'thereapist' => 'المعالج',
        'rozmana_count' => 'عدد الرزنامة',
        'rozmana_details' => 'تفاصيل الرزنامة',
        'rozmana_created_successfully' => 'تم إضافة الزنامة بنجاح',
        'rozmana_updated_successfully' => 'تم تعديل الرزنامة بنجاح',
        'rozmana_not_fount' => 'الرزنامة غير موجودة',
        'rozmana_deleted_successfully' => 'تم حذف الرزنامة بنجاح',
    ],

    'lecture_report' => [
        'title' => 'تقرير المحاضرات',
        'start_date' => 'تاريخ البدايه',
        'end_date' => 'تاريخ النهاية',
    ],

    'select2' => [
        'no_results' => 'لا توجد نتائج',
        'searching' => 'جاري البحث...',
        'input_too_short' => 'من فضلك اكتب علي الاقل حرفين',
    ],

    'settings' => [
        'title' => 'الاعدادات',
        'general_settings' => 'اعدادات عامه',
        'about_us'=>'عنا',
        'privacy'=>'الشروط والاحكام',
        'support_phone'=>'تواصل معنا',

    ],

    'system' => [
        'title' => 'النظام',
        'role_name' => 'الدور',
        'add_role' => 'اضافة الادوار',
        'roles' => 'الادوار',
        'roles_and_permissions' => 'الادوار والصلاحيات',
        'users_count' => 'عدد المستخدمين',
        'permissions_count' => 'عدد الصحلاحيات',
        'users_list' => 'قايمة المستخدمين',
        'add_user' => 'إضافة مستخدم',
        'edit_user' => 'تعديل مستخدم',

        'permissions' => [
            'therapists' => [
                'title' => 'المعالجين',
                'create_therapist' => 'إضافة معالج',
                'edit_therapist' => 'تعديل المعالج',
                'delete_therapist' => 'حذف المعالج',
                'change_therapist_status' => 'تغير حالة المعالج',
            ],
            'specialists' => [
                'title' => "التخصصات",
                   'list_specialists' => 'عرض التخصصات',
                   'create_specialist' => 'إنشاء تخصص',
                   'edit_specialist' => 'تعديل التخصص',
                   'delete_specialist' => 'حذف التخصص',
                   'change_specialists_status' => 'تغيير الحالة',
            ],
            'lectures' => [
                'title' => "المحاضرات",
                'lecture_report' => 'تقرير المحاضرة',
                'list_lectures' => 'عرض المحاضرات',
                'edit_lectures' => 'تعديل المحاضرات',
                'delete_lectures' => 'حذف المحاضرات',
                'change_image_cover' => 'تغيير صورة الغلاف',
                'change_lectures_status' => 'تغيير الحالة',
            ],
            'invoices' => [
                'title' => "الفواتير",
                 'list_invoices' => 'قائمة الفواتير',
                 'change_invoices_status' => 'تغيير الحالة',
                'add_therapist_Invoice' => 'أضف فاتورة المعالج'
            ],

            'sliders' => [
                'title' => 'شريط السحب',
                'list_slider' => 'قائمة شريط السحب',
                'create_slider' => 'إضافة',
                'edit_slider' => 'تعديل',
                'delete_slider' => 'حذف ',
                'change_slider_status' => 'تغير حالة شريط السحب',
            ],

            'interests' => [
                'title' => 'الاهتمامات',
                'list_interests' => 'قائمة الاهتمامات',
                'create_interest' => 'إضافة إهتمام',
                'edit_interest' => 'تعديل إهتمام',
                'delete_interest' => 'حذف إهتمام',
                'change_interest_status' => 'تغير حالة إهتمام',
            ],

            'plan' => [
                'title' => "الخطة",
                'show_plan', 'عرض الخطة'
            ],

            'categories' => [
                'title' => 'الاقسام',
                'name'=>'اسم التخصص',
                'create_category' => 'إضافة قسم',
                'edit_category' => 'تعديل قسم',
                'delete_category' => 'حذف القسم',
            ],

            'rozmana' => [
                'title' => 'رزنامة',
                'list_rozmana' => 'قائمة الرزنامة',
                'view_rozmana' => 'عرض الرزنامة',
            ],

            'clients' => [
                'title' => 'العملاء',
                'list_clients' => 'قائمة العملاء',
                'view_clients' => 'عرض العملاء',
            ],

            'users' => [
                'title' => 'المستخدمين',
                'list_users' => 'قائمة المستخدمين',
                'create_users' => 'إضافة مستخدم',
                'edit_users' => 'تعديل مستخدم',
                'delete_users' => 'حذف مستخدم',
                'change_users_status' => 'تغير حالة المستخدم',

            ],

            'roles' => [
                'title' => 'الادوار',
                'list_role' => 'قائمة الادوار',
                'create_role' => 'إضافة دور',
                'edit_role' => 'تعديل الدور',
                'delete_role' => 'حذف الدور',
            ],
            'appointments' => [
                'title' => "المواعيد",
                'list_appointment' => 'عرض المواعيد',
            ],
            'settings' => [
                'title' => "الإعدادات",
                'show_setting' => 'إظهار الإعداد',
            ],
        ],
    ],

];

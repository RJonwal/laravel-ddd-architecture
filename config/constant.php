<?php

return [
    'default' => [
        'logo' => 'default/logo.png',
        'favicon' => 'default/favicon.png',
        'no_image' => 'default/no-image.jpg',
        'staff-image' => 'default/staff-img.png',
        'building-image' => 'default/building-image.png',
        'help_pdf' => 'default/help_pdf.pdf',
        'user_icon' => 'default/user-icon.svg',
        'datatable_loader' => 'default/datatable_loader.gif',
        'group_icon' => 'images/groupIcon.svg',
        'firebase_json_file' => storage_path('app/firebase-auth.json'),
        'page_loader' => 'default/page-loader.gif',
    ],
    'profile_max_size' => 2048,
    'profile_max_size_in_mb' => '2MB',

    'roles' =>[
        'super_admin' => 1,
        'user' => 2,
        'team_leader' => 3
    ],

    'user_status' => [
        'active' => 'Active',
        'inactive' => 'Deactive'
    ],

    'staff_info' => [
        1 => 'Yes',
        0 => 'No'
    ],

    'shop_description_length' => 200,
    'travel_info_length' => 200,
    'company_number_prefix' => 'SS',
    'company_number_start' => '000001',
    'staff_document_agreement_text' => 'I agree with the terms and conditions of document submission.',

    'staff_file_fields' => [
        'user_dbs_certificate',
        'user_cv',
        'user_training_doc',
        'user_staff_budge',
        'user_dbs_check',
        'user_training_check'
    ],

    'date_format' => [
        'date' => 'd-m-Y',
        'time' => 'H:i',
        'date_time' => 'd-m-Y H:i:s'
    ],

    'search_date_format' => [ //$whereFormat = '%m/%d/%Y %h:%i %p';
        'date' => '%d-%m-%Y',
        'time' => '%H:%i',
        'date_time' => '%d-%m-%Y %H:%i:%s'
    ],

    'js_date_format' => [ //$whereFormat = '%m/%d/%Y %h:%i %p';
        'date' => 'dd-mm-yy',
        'time' => 'H:i',
        // 'date_time' => 'dd-mm-%Y %H:%i:%p'
    ],

    'shift_status' => [
        'open' => 'Open',
        'picked' => 'Picked',
        'cancel' => 'Cancel',
        'complete' => 'Complete',
        'not picked' => 'Not Picked'
    ],

    'ratings' =>[
        1 => '1 Star',
        2 => '2 Star',
        3 => '3 Star',
        4 => '4 Star',
        5 => '5 Star',
    ],

    'timepicker_step' => 15,
     //'timepicker_step' => 5,
    'timepicker_min_time' => '00:00',
    'timepicker_max_time' => '24:00',

    'notification_subject' => [
        'help_chat'     => 'Help Chat',
        'announcements' => 'Announcements',
    ],

    'subject_notification_type' => [
        /* shifts */
        'shift_available'                   => 'Shift Available',
        'shift_assign'                      => 'Shift Assign',
        'shift_pickings'                    => 'Shift Pickings',
        'shift_amendments'                  => 'Shift Amendments',
        'shift_cancellations'               => 'Shift Cancellations',
        'shift_changes'                     => 'Shift Changes',
        'shift_uploads'                     => 'Shift Uploads',
        'shifts_completed'                  => 'Shift Completed',
        'shift_cancels'                     => 'Shift Cancels',
        'shift_ratings'                     => 'Shift Rating',
        'shift_delete'                      => 'shift Delete',
        
        // subscription
        'subscription_expire_reminder'      => 'Subscription Expire Reminder',

        /* for registrations */
        'registration_completion_active'    => 'Registration is complete, account is activated',
        'registration_completion_deactive'  => 'Registration is complete, Account is deactivated',

        /* For Account activate */
        'user_account_active'               => 'Account is activated',
        'user_account_deactive'             => 'Account is deactivated',

        /* for staff */
        'clock_in'                          => 'Clock In',
        'clock_out'                         => 'Clock Out',
        'authorised_sign'                   => 'Authorised Sign Off Timesheet',

        // reminder for staff
        'clock_in_reminder'                 => 'Clock In Reminder',
        'clock_out_reminder'                => 'Clock Out Reminder',

    ],

    'upcoming_add_hour_to_end_time' => 24,

    'notification_routes' => [
        'shifts' => [
            'shift_available',
            'shift_assign',
            'shift_pickings',
            'shift_amendments',
            'shift_cancellations',
            'shift_changes',
            'shift_uploads',
            'shifts_completed',
            'shift_cancels',
            'shift_ratings',
            'shift_delete',
        ],

        'staffs' => [
            'clock_in',
            'clock_out',
            'authorised_sign',
            'registration_completion_active',
            'registration_completion_deactive',
        ],

        'messages'=>[
            'send_message',
            'send_notification'
        ]
    ],

    'send_notification_to_parent'=>[
        'pick_shift' => [
           'super_admin' => true,
           'sub_admin'  => true,
        ],
        'clock_in_shift' => [
            'super_admin' => true,
           'sub_admin'  => true,
        ],
        'clock_out_shift' => [
            'super_admin' => true,
           'sub_admin'  => true,
        ],
        'cancel_shift' => [
            'super_admin' => true,
            'sub_admin'  => true,
        ],
        'authorized_sign' => [
            'super_admin' => true,
            'sub_admin'  => true,
        ],
        'registration_completion_deactive' => [
            'super_admin' => true,
            'sub_admin'  => true,
        ],
    ],

    // Notification Reminder time
    'notification_reminder' =>[
        'before_clock_in_shift' => env('BEFORE_SHIFT_CLOCK_IN_REMINDER', 15),
        'after_clock_out_shift' => env('AFTER_SHIFT_CLOCK_OUT_REMINDER', 15),
    ],

    'currency' => 'gbp',
    'currency_symbol' => '£',
    'checkout_session_expiry' => env('STRIPE_SESSION_EXPIRY', 3600), // Default: 1 hour (3600 seconds)

    'plan_type' => [
        'default' => 'Default',
        'custom'  => 'Custom',
    ],

    'plan_interval' => [
        'month'   => 'Monthly',
        'year'    => 'Yearly',
    ],

    'plan_discount' => 5,

    'staff_app_links' => [
        'android' => 'https://play.google.com/store/apps/details?id=com.shiftspanapp&pli=1',
        'ios' => 'https://apps.apple.com/in/app/shiftspan-for-staff/id6502696173'
    ],

    'demo_video_links' => [
        'client_panel' => 'https://youtu.be/XwCo8Vp1l6Q',
        'app_panel' => 'https://youtu.be/6FZpSKjVYCQ'
    ],

    'subscription_reminder_before_days' => [
        'month' => [7, 1],
        'year' => [30, 14, 7, 1]
    ]
];

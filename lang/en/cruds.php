<?php

return [

    'menus' => [
        'dashboard' => 'Dashboard',
        'setting'   => 'Settings',
        'user'      => "Users",
        'rating'    => "Reviews and Ratings",
        'contact'    => "Queries",
        'announcement'    => "Announcements",
        'subscription_plan'    => "Subscription Packages",
        'subscription_history'    => "Subscription History",
    ],

    'datatable' => [
        'show'    => 'Show',
        'entries' => 'entries',
        'showing' => 'Showing',
        'to'      => 'to',
        'of'      => 'of',
        'search'  => 'Search',
        'previous' => 'Previous',
        'next'     => 'Next',
        'first'    => 'First',
        'last'     => 'Last',
        'data_not_found' => 'Data not found',
        'processing'     => 'Processing...',
    ],

    'dashboard' =>  [
        'title'          => 'Dashboard',
        'title_singular' => 'Dashboard',
        'fields'         => [],
    ],

    'header' =>  [
        'title'          => 'Header',
        'title_singular' => 'Header',
        'fields'         => [],
    ],

    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'            => 'ID',
            'name'          => 'Name',
            'email'         => 'Email',
            'phone'         => 'Phone',
            'password'      => 'Password',
            'confirm_password' => 'Confirm Password',
            'profile_image' => 'Profile Image',
            'type'          => 'Type',
            'status'        => 'Status',
            'created_at'    => 'Created Date',
            'updated_at'    => 'Updated',
            'deleted_at'    => 'Deleted',
        ],
    ],

    'user_rating'           => [
        'title'          => 'Reviews and Ratings',
        'title_singular' => 'Review and Rating',
        'fields'         => [
            'id'           => 'ID',
            'user_name'    => 'User Name',
            'rating'       => 'Rating',
            'review'       => 'Review',
            'created_at'   => 'Created Date',
            'updated_at'   => 'Updated',
            'deleted_at'   => 'Deleted',
        ],
    ],

    'contact'           => [
        'title'          => 'Queries',
        'title_singular' => 'Query',
        'fields'         => [
            'id'           => 'ID',
            'name'         => 'Name',
            'email'        => 'Email',
            'subject'      => 'Subject',
            'message'      => 'Message',
            'created_at'   => 'Created Date',
            'updated_at'   => 'Updated',
            'deleted_at'   => 'Deleted',
        ],
    ],

    'subscription_plan'           => [
        'title'          => 'Subscription Packages',
        'title_singular' => 'Subscription Package',
        'fields'         => [
            'name'         => 'Name',
            'description'  => 'Description',
            'price'        => 'Price',
            'interval'     => 'Interval',
            'duration'     => 'Duration ( In Days )',
            'subscription_id' => "Subscription Id",
            'google_product_id' => "Google Product Id",
            'status'       => 'Status',
            'created_at'   => 'Created Date',
            'updated_at'   => 'Updated',
            'deleted_at'   => 'Deleted',
        ],
    ],

    'subscription_history'           => [
        'title'          => 'Subscription Histories',
        'title_singular' => 'Subscription History',
        'fields'         => [
            'user_name'                 => 'User Name',
            'subscription_plan_name'    => 'Package Name',
            'start_date'                => 'Start Date',
            'end_date'                  => 'End Date',
            'amount'                    => 'Amount',
            'transaction_id'            => 'Transaction ID',
            'status'                    => 'Status',
            'payment_status'            => 'Payment Status',
            'created_at'                => 'Purchase Date',
            'updated_at'                => 'Updated',
            'deleted_at'                => 'Deleted',
        ],
    ],

    'setting' => [
        'title' => 'Settings',
        'add_message_subject' => 'Add Message Subject',
        'title_singular' => 'Setting',
        'site'          => 'Site',
        'support'          => 'Support',
        'site_setting'          => 'Site Setting',
        'support_setting'          => 'Support Setting',
    ],

    'staff' => [
        'title' => 'Staffs',
        'title_singular' => 'Staff',
        'fields' => []
    ],

    'announcement'           => [
        'title'          => 'Announcements',
        'title_singular' => 'Announcement',
        'fields'         => [
            'id'           => 'ID',
            'title'        => 'Title',
            'message'      => 'Message',
            'user'      => 'Users',
            'created_at'   => 'Created Date',
            'updated_at'   => 'Updated',
            'deleted_at'   => 'Deleted',
            'select_user'   => 'Select Users',
        ],
    ],


];

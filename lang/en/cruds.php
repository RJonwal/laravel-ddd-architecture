<?php

return [

    'menus' => [
        'dashboard' => 'Dashboard',
        'setting'   => 'Settings',
        'user'      => "Users",
        'rating'    => "Reviews and Ratings",
        'technology'    => "Technologies",
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

    'setting' => [
        'title' => 'Settings',
        'add_message_subject' => 'Add Message Subject',
        'title_singular' => 'Setting',
        'site'          => 'Site',
        'support'          => 'Support',
        'site_setting'          => 'Site Setting',
        'support_setting'          => 'Support Setting',
    ],

    'technology'     => [
        'title'          => 'Technologies',
        'title_singular' => 'Technology',
        'fields'         => [
            'id'                => 'ID',
            'name'              => 'Name',
            'description'       => 'Description',
            'technology_type'   => 'Technology Type',
            'created_at'        => 'Created at',
            'updated_at'        => 'Updated at',
            'deleted_at'        => 'Deleted at',
        ],
    ],

];

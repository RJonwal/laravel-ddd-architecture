<?php

return [

    'menus' => [
        'dashboard' => 'Dashboard',
        'setting'   => 'Settings',
        'user'      => "Users",
        'rating'    => "Reviews and Ratings",
        'technology'    => "Technologies",
        'project'    => "Projects",
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

    'project'     => [
        'title'                     => 'Projects',
        'title_singular'            => 'Project',
        'project_details'           => 'Project Details',
        'project_overview'          => 'Project Overview',
        'download_all_attachment'   => 'Download all attachment',
        'no_attachment'             => 'No Attachment',
        'fields'         => [
            'id'                        => 'ID',
            'name'                      => 'Name',
            'start_date'                => 'Start Date',
            'end_date'                  => 'End Date',
            'project_lead'              => 'Project Lead',
            'assign_developers'         => 'Assign Developers',
            'remarks'                   => 'Remarks',
            'project_status'            => 'Status',
            'technology'                => 'Technology',
            'description'               => 'Description',
            'attachment'                => 'Attachment',
            'refrence_details'          => 'Reference details',
            'live_url'                  => 'Live URL',
            'credentials'               => 'Credentials',
            'created_by'                => 'Created By',
            'created_at'                => 'Created at',
            'created'                   => 'Created',
            'updated_at'                => 'Updated at',
            'updated'                   => 'Updated',
            'deleted_at'                => 'Deleted at',
        ],
    ],
];

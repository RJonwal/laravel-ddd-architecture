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
    ],

    'technology_types' => [
        'frontend'          => 'Frontend',
        'backend'           => 'Backend',
        'database'          => 'Database',
        'designing'         => 'Designing',
        'devops'            => 'DevOps',
        'mobile'            => 'Mobile Development',
        'testing'           => 'Testing / QA',
        'version_control'   => 'Version Control',
        'cloud'             => 'Cloud Services',
        'api'               => 'API / Integration',
        'security'          => 'Security',
        'project_tools'     => 'Project / Team Tools',
        'analytics'         => 'Analytics & Monitoring',
        'ai_ml'             => 'AI / Machine Learning',
        'desktop'           => 'Desktop Development',
        'game'              => 'Game Development',
        'blockchain'        => 'Blockchain',
        'iot'               => 'IoT',
        'other'             => 'Other',
    ],

    'project_status' => [
        'start'     => 'Start',
        'hold'     => 'Hold',
        'progress'     => 'Progress',
        'complete'     => 'Complete',
    ],
];

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
        'date' => 'd M Y',
        'time' => 'h:i A',
        'date_time' => 'd M Y, h:i A'
    ],

    'search_date_format' => [ //$whereFormat = '%m/%d/%Y %h:%i %p';
        'date' => '%d %b %Y',
        'time' => '%h:%i %p',
        'date_time' => '%d %b %Y, %h:%i %p'
    ],

    'js_date_format' => [
        'date' => 'dd M yyyy',           // e.g., 19 May 2025
        'time' => 'hh:ii A',             // Requires timepicker support
        'date_time' => 'dd M yyyy, hh:ii A'
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

    'task_priority' => [
        'low'       => 'Low',
        'medium'    => 'Medium',
        'high'      => 'High'
    ],
    'task_status'       => [
        'initial'       => 'Initial',
        'in_progress'   => 'In Progress',
        'completed'     => 'Completed',
    ],
    'milestone_status' => [
        'initial'       => 'Initial',
        'in_progress'   => 'In Progress',
        'completed'     => 'Completed',
        'not_started'   => 'Not started',
    ],
];

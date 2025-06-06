<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="javascript::void(0);" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            {{-- Dashboard Menu --}}
            <li class="side-nav-item {{ request()->is('dashboard') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link {{ request()->is('dashboard') ? 'active' : ''}}">
                    <i class="ri-dashboard-3-line"></i>
                    <span> @lang('cruds.menus.dashboard') </span>
                </a>
            </li>

            {{-- User Menu --}}
            @can('user_access')
            <li class="side-nav-item {{ request()->is('users') ? 'menuitem-active' : ''}}">
                <a href="{{ route('users.index') }}" class="side-nav-link {{ request()->is('users') ? 'active' : ''}}">
                    <i class=" ri-group-line"></i>
                    <span> @lang('cruds.menus.user') </span>
                </a>
            </li>
            @endcan

            {{-- Contact Menu --}}
            @can('technology_access')
            <li class="side-nav-item {{ request()->is('technologies') ? 'menuitem-active' : ''}}">
                <a href="{{ route('technologies.index') }}" class="side-nav-link {{ request()->is('technologies') ? 'active' : ''}}">
                    <i class=" ri-tools-line"></i>
                    <span> @lang('cruds.menus.technology') </span>
                </a>
            </li>
            @endcan

            @can('project_access')
            <li class="side-nav-item {{ request()->is('projects/*') ? 'menuitem-active' : ''}}">
                <a href="{{ route('projects.index') }}" class="side-nav-link {{ request()->is('projects/*') ? 'active' : ''}}">
                    <i class=" ri-briefcase-3-fill"></i>
                    <span> @lang('cruds.menus.project') </span>
                </a>
            </li>
            @endcan
            
            {{-- Milestone Menu --}}
            @can('milestone_access')
            <li class="side-nav-item {{ request()->is('milestones') ? 'menuitem-active' : ''}}">
                <a href="{{ route('milestones.index') }}" class="side-nav-link {{ request()->is('milestones') ? 'active' : ''}}">
                    <i class=" ri-calendar-check-line"></i>
                    <span> @lang('cruds.menus.milestone') </span>
                </a>
            </li>
            @endcan

            {{-- Sprint Menu --}}
            @can('sprint_access')
            <li class="side-nav-item {{ request()->is('sprints') ? 'menuitem-active' : ''}}">
                <a href="{{ route('sprints.index') }}" class="side-nav-link {{ request()->is('sprints') ? 'active' : ''}}">
                    <i class=" ri-timer-line"></i>
                    <span> @lang('cruds.menus.sprint') </span>
                </a>
            </li>
            @endcan

            {{-- Task Menu --}}
            @can('task_access')
            <li class="side-nav-item {{ request()->is('tasks') ? 'menuitem-active' : ''}}">
                <a href="{{ route('tasks.index') }}" class="side-nav-link {{ request()->is('tasks') ? 'active' : ''}}">
                    <i class=" ri-task-line"></i>
                    <span> @lang('cruds.menus.task') </span>
                </a>
            </li>
            @endcan

            {{-- Daily Task log Menu --}}
            @canany(['daily_activity_log_access','admin_daily_activity_log_access'])
            <li class="side-nav-item {{ request()->routeIs('daily-activity-logs.*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('daily-activity-logs.index') }}" class="side-nav-link {{ request()->routeIs('daily-activity-logs.*') ? 'active' : '' }}">
                    <i class="ri-file-list-line"></i>
                    <span>@lang('cruds.menus.daily_activity_logs')</span>
                </a>
            </li>
            @endcanany

            {{-- Setting Menu --}}
            @can('setting_access')
            <li class="side-nav-item {{ request()->routeIs('get.site.setting') ? 'menuitem-active' : '' }}">
                <a href="{{ route('get.site.setting') }}" class="side-nav-link {{ request()->routeIs('get.site.setting') ? 'active' : '' }}">
                    <i class="ri-settings-line"></i>
                    <span>@lang('cruds.menus.setting')</span>
                </a>
            </li>
            @endcan

            {{-- Rating Menu --}}
            {{-- @can('rating_access')
            <li class="side-nav-item {{ request()->is('user-ratings') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.ratings.index') }}" class="side-nav-link {{ request()->is('admin/user-ratings') ? 'active' : ''}}">
                    <i class=" ri-shield-star-line"></i>
                    <span> @lang('cruds.menus.project') </span>
                </a>
            </li>
            @endcan--}}

            {{-- Announcement Menu --}}
            {{-- @can('announcement_access')
            <li class="side-nav-item {{ request()->is('admin/announcements') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.announcements.index') }}" class="side-nav-link {{ request()->is('admin/announcements*') ? 'active' : ''}}">
                    <i class="ri-megaphone-line"></i>
                    <span> @lang('cruds.menus.announcement')</span>
                </a>
            </li>
            @endcan --}}

            {{-- Subscription Packages Menu --}}
            {{-- @can('subscription_plan_access')
            <li class="side-nav-item {{ request()->is('subscription-packages') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.subscription-packages.index') }}" class="side-nav-link {{ request()->is('admin/subscription-packages') ? 'active' : ''}}">
                    <i class="ri-vip-crown-2-line"></i>
                    <span> @lang('cruds.menus.subscription_plan') </span>
                </a>
            </li>
            @endcan --}}

            {{-- Subscription Packages Menu --}}
            {{-- @can('subscription_history_access')
            <li class="side-nav-item {{ request()->is('subscription-histories') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.subscription-histories.index') }}" class="side-nav-link {{ request()->is('admin/subscription-histories') ? 'active' : ''}}">
                    <i class="ri-history-line"></i>
                    <span> @lang('cruds.menus.subscription_history') </span>
                </a>
            </li>
            @endcan --}}

            {{-- Setting Menu --}}
            {{-- @can('setting_access')
            <li class="side-nav-item {{ request()->is('settings') ? 'menuitem-active' : ''}}">
                <a href="{{ route('admin.show.setting') }}" class="side-nav-link {{ request()->is('admin/settings') ? 'active' : ''}}">
                    <i class="ri-settings-3-line"></i>
                    <span> @lang('cruds.menus.setting') </span>
                </a>
            </li>
            @endcan --}}
           
            @can('company_access')
            {{-- <li class="side-nav-item {{ request()->is('admin/companies*') ? 'menuitem-active' : ''}}">
                <a data-bs-toggle="collapse" href="#companyLayouts" aria-expanded="false" aria-controls="companyLayouts" class="side-nav-link">
                    <i class="ri-layout-line"></i>
                    <span> Companies </span>
                </a>
                <div class="collapse {{ request()->is('admin/companies*') ? 'show' : ''}}" id="companyLayouts">
                    <ul class="side-nav-second-level">
                        <li class="{{ request()->is('admin/companies*') && (!request()->is('admin/companies/create')) ? 'menuitem-active' : ''}}">
                            <a href="{{ route('admin.companies.index') }}" class="{{ request()->is('admin/companies*') && (!request()->is('admin/companies/create')) ? 'active' : ''}}">List</a>
                        </li>
                        <li class="{{ request()->is('admin/companies/create') ? 'menuitem-active' : ''}}">
                            <a href="{{ route('admin.companies.create') }}">@lang('global.create')</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            @endcan
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
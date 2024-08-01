<?php
    $route = \Route::currentRouteName();
    $assetsPath = asset('assets/admin');
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <h2 class="brand-text">{{ config('app.name') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">{{ __('admin.dashboard') }}</span>
                </a>
            </li>
          

           
          

       
            @can('school.view')
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('school.index') }} ">
                    <i data-feather="columns"></i>
                    <span class="menu-item text-truncate" data-i18n="List"> المدارس </span>
                </a>
            </li>
            @endcan

            @can('contract.view')
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('contract.index') }} ">
                    <i data-feather="columns"></i>
                    <span class="menu-item text-truncate" data-i18n="List"> {{ __('contract.plural') }} </span>
                </a>
            </li>
            @endcan

            @can('service.view')
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('service.index') }} ">
                    <i data-feather="columns"></i>
                    <span class="menu-item text-truncate" data-i18n="List"> {{ __('service.plural') }} </span>
                </a>
            </li>
            @endcan
         
         
        
       
        </ul>
    </div>
</div>


@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.settings') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="settings" class="font-medium-2"></i>
                        <span>{{ __('admin.settings') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">

            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
            <div class="row">
<div class="col-md-12">
    @isset($numbers)
    <div class="alert alert-success">تم الارسال بنجاح</div>
    @endisset
</div>
<div class="row">
                @can('settings.userLinks')
                <div class="col-md-3" style="margin-bottom: 20px">
                    <a class="btn btn-outline-primary me-1 waves-effect col-md-12" href="{{ route('userLinks') }}">
                        <i data-feather="users"></i>
                        <span class="active-sorting text-primary">{{ __('admin.update_user_links') }}</span>
                    </a>
                </div>
                    @endcan

                 @can('settings.projectLinks')
                <div class="col-md-3" style="margin-bottom: 20px">

                 <a class="btn btn-outline-primary me-1 waves-effect col-md-12" href="{{ route('userLinks') }}">
                   <i data-feather="database"></i>
                   <span class="active-sorting text-primary">{{ __('admin.update_user_projects') }}</span>
                </a>
                </div>
                @endcan

                @can('settings.categoryLinks')
                <div class="col-md-3" style="margin-bottom: 20px">

                <a class="btn btn-outline-primary me-1 waves-effect col-md-12" href="{{ route('categoryLinks') }}">
                  <i data-feather="columns"></i>
                  <span class="active-sorting text-primary">{{ __('admin.update_links_categories') }}</span>
               </a>
                </div>
               @endcan
              
        </div>
        </div>

        </div>
        </div>
    </div>
@stop

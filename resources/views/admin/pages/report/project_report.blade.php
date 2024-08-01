@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.project_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="settings" class="font-medium-2"></i>
                        <span>{{ __('admin.project_report') }}</span>
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
    @if (count($numbers)>0)
    تم الارسال الى الارقام التاليه
    <ul class="alert alert-success">
        @foreach ($numbers as $number)
        <li>{{ $number }}</li>
        @endforeach
    </ul>
    @endif
    @endisset
</div>
                @can('settings.userLinks')
                <div class="col-md-3">
                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('commplete_project_category') }}">
                        <i data-feather="users"></i>
                        <span class="active-sorting text-primary">
                            {{ __('admin.complete_project_catgory') }} 
                        </span>
                    </a>
                </div>
                    @endcan

                 @can('settings.projectLinks')
                <div class="col-md-3">

                 <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('uncommplete_project_category') }}">
                   <i data-feather="users"></i>
                   <span class="active-sorting text-primary">
                     {{ __('admin.uncomplete_project_catgory') }} 
                   </span>
                </a>
                </div>
                @endcan



        </div>

        </div>
        </div>
    </div>
@stop

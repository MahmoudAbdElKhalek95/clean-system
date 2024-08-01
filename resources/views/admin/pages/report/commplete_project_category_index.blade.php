@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.project_report_compelte') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.project_report_compelte') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                  {{-- @can('links.create')

                  <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('links.create') }}">
                    <i data-feather="plus"></i>
                    <span class="active-sorting text-primary">{{ __('links.actions.create') }}</span>
                </a>
                @endcan --}}

                {{-- @include('admin.pages.report.filter') --}}

                {{-- start filter --}}
                {{-- <div class="row">
                <div class="col col-md3">
                  <div class="form-group row >
                    <label for="time" class="col-sm-2 col-form-label">   من الوقت </label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="time"  value="">

                    </div>
                </div>
                </div>
                <div class="col col-md3">
                <div class="form-group row >
                    <label for="time" class="col-sm-2 col-form-label">   الي الوقت </label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="time"  value="">

                    </div>
                </div>
                </div>

                </div> --}}
                {{-- end filter --}}
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('projects.id') }}</th>
                        <th>{{ __('projects.name') }}</th>
                        <th>{{ __('projects.code') }}</th>
                        <th>{{ __('projects.category') }}</th>
                        <th>{{ __('projects.percent') }}</th>


                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as   $item )
                        <tr>

                            <td>{{ $item->id   }}</td>
                            <td>{{  $item->name  }}</td>
                            <td>{{  $item->code  }}</td>
                            <td>{{  $item->category->name ?? ''  }}</td>
                            <td>{{  $item->getPercent() ??  0   }}</td>
                        </tr>    

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@push('scripts')
    <script>
       </script>
@endpush

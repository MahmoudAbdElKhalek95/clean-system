@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.saller_group') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.saller_group') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    {{-- @include('admin.pages.reports.filter') --}}
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('admin.saller_group') }}</th>
                        <th>{{ __('users.amount') }}</th>
                        <th>{{ __('users.total') }}</th>
                        <th>{{ __('users.links_archieved') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=>$val)
                        @php
                            $total=0;
                            $amount=0;
                        @endphp
                        @foreach ($val as $row)
                            <?php
                            $amount +=$row['amount'];
                            $total +=$row['total'];
                            ?>
                        @endforeach
                            <tr>
                                <td>{{ $key }}</td>
                                <td>
                                    {{ $amount }}
                                </td>
                                <td>
                                    {{ $total }}
                                </td>
                                <td>
                                    {{ round($total/3900,2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot >
                        <tr>
                            <th>{{ __('users.total') }}</th>
                            <th>{{ $total_amount }}</th>
                            <th>{{ $total_total }}</th>
                            <th colspan="3"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@stop

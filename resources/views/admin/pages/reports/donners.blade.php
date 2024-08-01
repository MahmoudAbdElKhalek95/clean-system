@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.doners_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.doners_report') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
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
                        <th>الفئة</th>
                        <th>العدد</th>
                        <th>المبلغ</th>
                        <th>المتكرر</th>
                        <th>المبلغ</th>
                        <th>مرة واحدة</th>
                        <th>المبلغ</th>
                        <th>العمليات</th>
                        <th>النسبة من اجمالى الايراد</th>
                    </tr>
                    </thead>
                 <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->donner_number }}</td>
                            <td>{{ $row->single_price }}</td>
                            <td>{{ $row->single_number }}</td>
                            <td>{{ $row->repeat_price }}</td>
                            <td>{{ $row->repeat_number }}</td>
                            <td>{{ $row->single_price+$row->repeat_price }}</td>
                            <td>{{ $row->operation_number }}</td>
                            <td>{{ round((($row->single_price+$row->repeat_price)/$total)*100,4) }}%</td>

                        </tr>
                    @endforeach
                    <tfoot>

                        <tr >
                            <th>الايراد</th>
                            <th colspan="8">{{ $total }}</th>
                        </tr>
                    </tfoot>
                 </tbody>
                </table>
            </div>
        </div>
    </div>
@stop



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
                </table>
            </div>
        </div>
    </div>
@stop


@push('scripts')
    <script>
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: true,
            lengthMenu: [[10, 50, 100,500, -1], [10, 50, 100,500, "All"]],
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('doners.report') }}",
                data: function (d) {
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'total', name: 'total'},
                {data: 'name', name: 'name'},
                {data: 'total', name: 'total'},
                {data: 'name', name: 'name'},
                {data: 'total', name: 'total'},
                {data: 'name', name: 'name'},
                {data: 'total', name: 'total'},
                {data: 'total', name: 'total'},
            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush


@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.saller_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.saller_report') }}</span>
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
                        <th>{{ __('projects.name') }}</th>
                        <th>{{ __('projects.category') }}</th>
                        <th>{{ __('projects.amount') }}</th>
                        <th>{{ __('whatsapps.percent') }}</th>
                        <th>{{ __('whatsapps.current_archived') }}</th>
                        <th>{{ __('whatsapps.current_percent') }}</th>
                        <th>{{ __('whatsapps.diffrence') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin') }}/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
@endpush
@push('scripts')
  <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script>
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: true,
            lengthMenu: [[10, 50, 100,500, -1], [10, 50, 100,500, "All"]],
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
               buttons: [
                {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                    extend: 'print',
                    text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                    className: 'dropdown-item',
                    exportOptions: { columns: [0,1,2,3,4] }
                    },
                    {
                    extend: 'excel',
                    text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                    className: 'dropdown-item',
                    exportOptions: { columns: [0,1,2,3,4] }
                    },

                    {
                    extend: 'copy',
                    text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                    className: 'dropdown-item',
                    exportOptions: { columns: [0,1,2,3,4] }
                    }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                    $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
                },

            ],
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('whatsapps.report') }}",
                data: function (d) {

                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'project', name: 'project'},
                {data: 'category', name: 'category'},
                {data: 'archieved', name: 'archieved'},
                {data: 'percent', name: 'percent'},
                {data: 'current_archived', name: 'current_archived'},
                {data: 'current_percent', name: 'current_percent'},
                {data: 'diffrence', name: 'diffrence'}
            ]

        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush



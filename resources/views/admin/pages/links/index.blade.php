@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('links.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('links.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                  @can('links.create')

                  <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('links.create') }}">
                    <i data-feather="plus"></i>
                    <span class="active-sorting text-primary">{{ __('links.actions.create') }}</span>
                </a>
                @endcan

                @include('admin.pages.links.filter')
                @include('admin.pages.links.import')

            </div>

        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('links.project_name') }}</th>
                        <th>{{ __('links.project_percentage') }}</th>
                        <th>{{ __('links.project_dep_name') }}</th>
                        <th>{{ __('links.phone') }}</th>
                        <th>{{ __('links.total') }}</th>
                        <th>{{ __('links.user') }}</th>
                        <th>{{ __('links.code') }}</th>
                        <th>{{ __('links.date') }}</th>
                        <th>{{ __('links.type') }}</th>
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
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: true,
            lengthMenu: [[10, 50, 100,500, 1000], [10, 50, 100,500, 1000]],
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
                    exportOptions: { columns: [1,2,3,4,5,6,7] }
                    },
                    {
                    extend: 'excel',
                    text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1,2,3,4,5,6,7] }
                    },

                    {
                    extend: 'copy',
                    text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1,2,3,4,5,6,7] }
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
                type:'POST',
                url: "{{ route('links.list') }}",
                data: function (d) {
                    d.user_id   = $('#filterForm #user_id').val();
                    d.archive_id   = $('#filterForm #archive_id').val();
                    d.project_number   = $('#filterForm #project_id').val();
                    d.category_id   = $('#filterForm #category_id').val();
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'project_name', name: 'project_name'},
                {data: 'project_percentage', name: 'project_percentage',searchable: false},
                {data: 'project_dep_name', name: 'project_dep_name'},
                {data: 'phone', name: 'phone'},
                {data: 'total', name: 'total'},
                {data: 'user', name: 'user'},
                {data: 'code', name: 'code'},
                {data: 'date', name: 'date'},
                {data: 'type', name: 'type'},
            ],
            columnDefs: [
                {
                    "targets": 1,
                    "render": function (data, type, row) {

                      var percentage = Math.round(row.project_percentage,2);

                    if(percentage < 50){
                        return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                `+percentage+` %
                            </button>`;
                    }
                    if(percentage < 80 && percentage > 50){
                        return ` <button class="btn btn-sm btn-outline-warning me-1 waves-effect">
                                `+percentage+` %
                            </button>`;
                    }
                    if(percentage > 80){
                        return ` <button class="btn btn-sm btn-outline-success me-1 waves-effect">
                                `+percentage+` %
                            </button>`;
                    }
                    return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                0 %
                            </button>`;
                    }
                },
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

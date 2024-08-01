@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('projects.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('projects.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="row">

                <div class="mb-1 breadcrumb-right col-md-12" >
                    <div class="dropdown">
                        @include('admin.pages.projects.filter')
                        @can('projects.updatecode')
                        <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('projects.code') }}">
                            <i data-feather="plus"></i>
                            <span class="active-sorting text-primary">{{ __('projects.actions.updatecode') }}</span>
                        </a>
                        @endcan
                        @can('projects.create')
                        <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('projects.create') }}">
                            <i data-feather="plus"></i>
                            <span class="active-sorting text-primary">{{ __('projects.actions.create') }}</span>
                        </a>
                        @endcan
                    </div>
                </div>

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
                        <th>{{ __('projects.code') }}</th>
                        <th>{{ __('projects.name') }}</th>
                        <th>{{ __('projects.category') }}</th>
                        <th>{{ __('projects.last_date') }}</th>
                        <th>{{ __('projects.status') }}</th>
                        <th>{{ __('projects.quantityInStock') }}</th>
                        <th>{{ __('projects.price') }}</th>
                        <th>{{ __('projects.totalSalesTarget') }}</th>
                        <th>{{ __('projects.totalSalesDone') }}</th>
                        <th>{{ __('projects.percent') }}</th>
                        <th>{{ __('projects.number_donor') }}</th>
                        <th width="15%" class="text-center">{{ __('projects.options') }}</th>
                    </tr>
                    </thead>
                     <tfoot align="right">
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                    </tfoot>
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
                url: "{{ route('projects.list') }}",
                data: function (d) {
                    d.last_operation   = $('#filterForm #last_operation').val();
                    d.to   = $('#filterForm #to').val();
                    d.from   = $('#filterForm #from').val();
                    d.category_id  = $('#filterForm #category_id').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'code', name: 'code'},
                {data: 'name', name: 'name'},
                {data: 'category', name: 'category'},
                {data: 'last_date', name: 'last_date'},
                {data: 'status', name: 'status',orderable: false,searchable: false},
                {data: 'quantityInStock', name: 'quantityInStock'},
                {data: 'price', name: 'price'},
                {data: 'total_target', name: 'total_target'},
                {data: 'total_done', name: 'total_done',searchable: false},
                {data: 'percent', name: 'percent',searchable: false},
                {data: 'number_donor', name: 'number_donor',searchable: false},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {

                        var editUrl = '{{ route("projects.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("projects.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" class="font-medium-2"></i>
                                </button>
                                <div class="dropdown-menu">

                                    <a class="dropdown-item" href="`+editUrl+`">
                                    <i data-feather="edit-2" class="font-medium-2"></i>
                                        <span>{{ __('projects.actions.edit') }}</span>
                                    </a>
                                    <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                        <i data-feather="trash" class="font-medium-2"></i>
                                            <span>{{ __('projects.actions.delete') }}</span>
                                    </a>
                                </div>
                            </div>
                            `;
                    }
                },
                {
                    "targets": 9,
                    "render": function (data, type, row) {
                        var $achieved = 0;
                    if(row.total_target > 0 ){
                        var $achieved = Math.round(row.total_done/row.total_target * 100,2);
                    }else{
                        return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                X
                            </button>`;
                    }
                    if($achieved==="Infinity"){
                        return 0;
                    }
                    if($achieved < 50){
                        return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                `+$achieved+` %
                            </button>`;
                    }
                    if($achieved < 80 && $achieved > 50){
                        return ` <button class="btn btn-sm btn-outline-warning me-1 waves-effect">
                                `+$achieved+` %
                            </button>`;
                    }
                    if($achieved > 80){
                        return ` <button class="btn btn-sm btn-outline-success me-1 waves-effect">
                                `+$achieved+` %
                            </button>`;
                    }
                    return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                0 %
                            </button>`;
                    }
                },
                {
                    "targets": 4,
                    "render": function (data, type, row) {
                        var $achieved = 0;
                        if(row.total_target > 0 ){
                            var $achieved = row.total_done/row.total_target * 100;
                        }else{
                            return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                    {{ __('projects.statuses.2') }}
                                </button>`;
                            }
                        if($achieved==="Infinit  y"){
                            return ` <button class="btn btn-sm btn-outline-success me-1 waves-effect">
                                    {{ __('projects.statuses.2') }}
                                </button>`;
                        }
                        if($achieved < 100){
                            return ` <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                                    {{ __('projects.statuses.2') }}
                                    </button>`;
                        }
                        return ` <button class="btn btn-sm btn-outline-success me-1 waves-effect">
                            {{ __('projects.statuses.1') }}
                            </button>`;
                        }
                }

            ],
         footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                var totalAmount = api.column( 5 ).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                var TotalPrice = api.column( 6 ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                var column7 = api.column( 7 ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                var column8 = api.column( 8 ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                var column10 = api.column( 10 ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
	        $( api.column( 0 ).footer() ).html("{{ __('targets.total') }}");
            $( api.column( 5 ).footer() ).html(totalAmount);
            $( api.column( 6 ).footer() ).html(TotalPrice);
            $( api.column( 7 ).footer() ).html(column7);
            $( api.column( 8 ).footer() ).html(column8);
            $( api.column( 10 ).footer() ).html(column10);
        },
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        //  $(function() {
        //     $('#category_id').change(function () {
        //         dt_ajax.DataTable().ajax.reload();
        //     });

        // });
    </script>
@endpush

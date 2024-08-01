@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('whatsapps.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('whatsapps.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('whatsapps.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">{{ __('whatsapps.actions.create') }}</span>
                    </a>
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
                        <th>{{ __('whatsapps.category') }}</th>
                        <th>{{ __('whatsapps.percent') }}</th>
                        <th>القالب</th>
                        <th>{{ __('whatsapps.percent2') }}</th>
                        <th>تاريخ اخر ارسال</th>
                        {{-- <th>عدد الارقام المرسل اليها</th>
                        <th>عدد الارقام المتبقية</th> --}}
                        <th>ارسال رسائل</th>
                        <th width="15%" class="text-center">{{ __('whatsapps.options') }}</th>
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
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('whatsapps.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'category', name: 'category'},
                {data: 'percent', name: 'percent'},
                {data: 'message', name: 'message'},
                {data: 'percent2', name: 'percent2'},
                {data: 'last_send', name: 'last_send'},
                // {data: 'sendingCount',name: 'sendingCount',orderable: false,searchable: false},
                // {data: 'remainCount',name: 'remainCount',orderable: false,searchable: false},
                {data: 'sendMessage',name: 'sendMessage',orderable: false,searchable: false},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                //  {
                //     "targets": -4,
                //     "render": function (data, type, row,meta) {
                //         return JSON.parse(row.sendMessage).sended_phones;
                //     }
                // },
                //  {
                //     "targets": -3,
                //     "render": function (data, type, row,meta) {
                //         return JSON.parse(row.sendMessage).remain_phones;
                //     }
                // },
                 {
                    "targets": -2,
                    "render": function (data, type, row,meta) {
                        return JSON.parse(row.sendMessage).send_button;
                    }
                },
                {
                    "targets": -1,
                    "render": function (data, type, row) {

                        var editUrl = '{{ route("whatsapps.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("whatsapps.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" class="font-medium-2"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="`+editUrl+`">
                                    <i data-feather="edit-2" class="font-medium-2"></i>
                                        <span>{{ __('whatsapps.actions.edit') }}</span>
                                    </a>
                                    <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                        <i data-feather="trash" class="font-medium-2"></i>
                                            <span>{{ __('whatsapps.actions.delete') }}</span>
                                    </a>
                                </div>
                            </div>
                            `;
                    }
                }

            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

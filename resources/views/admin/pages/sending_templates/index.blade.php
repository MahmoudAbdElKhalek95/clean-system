@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sending_templates.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('sending_templates.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('sending_templates.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">{{ __('sending_templates.actions.create') }}</span>
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
                        <th>{{ __('sending_templates.template_name') }}</th>
                        <th>{{ __('sending_templates.var_number') }}</th>
                        <th>  المتغيرات   </th>
                       {{--
                        <th> المتغير الثاني   </th>
                        <th> المتغير الثالث  </th>  --}}


                        {{--  <th>{{ __('sending_templates.project_name') }}</th>
                        <th>{{ __('sending_templates.project_link') }}</th>
                        <th>{{ __('sending_templates.project_percent') }}</th>
                        <th>{{ __('sending_templates.photo') }}</th>
                        <th>{{ __('sending_templates.video') }}</th>  --}}



                        <th width="15%" class="text-center">{{ __('sending_templates.options') }}</th>
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
                url: "{{ route('sending_templates.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'template_name', name: 'template_name'},
                {data: 'var_number', name: 'var_number'},
                {data: 'vars', name: 'vars'},

               /* {data: 'param2', name: 'param2'},
                {data: 'param3', name: 'param3'},*/


                /*{data: 'project_name', name: 'project_name'},
                {data: 'project_link', name: 'project_link'},
                {data: 'project_percent', name: 'project_percent'},
                {data: 'image', name: 'image'},
                {data: 'video', name: 'video'},*/



                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {


                        var editUrl = '{{ route("sending_templates.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("sending_templates.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" class="font-medium-2"></i>
                                </button>
                                <div class="dropdown-menu">

                                      {{--  <a class="dropdown-item" href="`+editUrl+`">
                                    <i data-feather="edit-2" class="font-medium-2"></i>
                                        <span>{{ __('sending_templates.actions.edit') }}</span>
                                    </a>    --}}
                                    <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                        <i data-feather="trash" class="font-medium-2"></i>
                                            <span>{{ __('sending_templates.actions.delete') }}</span>
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

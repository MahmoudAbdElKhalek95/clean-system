@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('rate.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('rate.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('rate.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">{{ __('rate.actions.create') }}</span>
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
                        <th>{{ __('rate.supervisior_name') }}</th>
                        <th>{{ __('rate.manager_name') }}</th>
                        <th>{{ __('rate.rate_employee_performance') }}</th>
                        <th>{{ __('rate.rate_excuted_time') }}</th>
                        <th>{{ __('rate.rate_contious_visit') }}</th>
                        <th>{{ __('rate.rate_service') }}</th>
                        <th>{{ __('rate.rate_company') }}</th>
                        <th>{{ __('rate.rate_service_statisfied') }}</th>
                        <th>{{ __('rate.rate_service_statisfied_range') }}</th>






                        


                        <th width="15%" class="text-center">{{ __('rate.options') }}</th>
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
                url: "{{ route('rate.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'super', name: 'super' ,orderable: false },
                {data: 'manager', name: 'manager'},
                {data: 'rate_employee_performance', name: 'rate_employee_performance'},
                {data: 'rate_excuted_time', name: 'rate_excuted_time'},
                {data: 'rate_contious_visit', name: 'rate_contious_visit'},
                {data: 'rate_service', name: 'rate_service'},
                {data: 'rate_company', name: 'rate_company'},
                {data: 'rate_service_statisfied', name: 'rate_service_statisfied'},
                {data: 'rate_service_statisfied_range', name: 'rate_service_statisfied_range'},

                
               /* {data: 'vist_details', name: 'vist_details' },*/

                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {

                    
                        var editUrl = '{{ route("rate.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("rate.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" class="font-medium-2"></i>
                                </button>
                                <div class="dropdown-menu">

                                
                                    {{--  <a class="dropdown-item" href="`+editUrl+`">
                                    <i data-feather="edit-2" class="font-medium-2"></i>
                                        <span>{{ __('rate.actions.edit') }}</span>
                                    </a>  --}}
                                    {{--  <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                        <i data-feather="trash" class="font-medium-2"></i>
                                            <span>{{ __('rate.actions.delete') }}</span>
                                    </a>  --}}
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

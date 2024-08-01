@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('targets.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('targets.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('targets.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">{{ __('targets.actions.create') }}</span>
                    </a>
                    @include('admin.pages.targets.import')

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
                        <th>{{ __('targets.target_type') }}</th>
                        <th>{{ __('targets.target_name') }}</th>
                        <th>{{ __('targets.date_from') }}</th>
                        <th>{{ __('targets.date_to') }}</th>
                        <th>{{ __('targets.target') }}</th>
                        <th>{{ __('targets.achieved') }}</th>
                        <th>{{ __('targets.percent') }}</th>
                        <th width="15%" class="text-center">{{ __('targets.options') }}</th>
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
                url: "{{ route('targets.list') }}",
                data: function (d) {
                    d.section_id   = $('#filterForm #section_id').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'type', name: 'type'},
                {data: 'section', name: 'section'},
                {data: 'date_to', name: 'date_to'},
                {data: 'date_to', name: 'date_to'},
                {data: 'target', name: 'target'},
                {data: 'achieved', name: 'achieved'},
                {data: 'percent',name: 'percent',orderable: false,searchable: false},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {

                        var editUrl = '{{ route("targets.edit", ":id") }}';
                        editUrl = editUrl.replace(':id', row.id);

                        var deleteUrl = '{{ route("targets.destroy", ":id") }}';
                        deleteUrl = deleteUrl.replace(':id', row.id);
                        return `
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical" class="font-medium-2"></i>
                                </button>
                                <div class="dropdown-menu">

                                    <a class="dropdown-item" href="`+editUrl+`">
                                    <i data-feather="edit-2" class="font-medium-2"></i>
                                        <span>{{ __('targets.actions.edit') }}</span>
                                    </a>
                                    <a class="dropdown-item delete_item" data-url="`+deleteUrl+`" href="#">
                                        <i data-feather="trash" class="font-medium-2"></i>
                                            <span>{{ __('targets.actions.delete') }}</span>
                                    </a>
                                </div>
                            </div>`;
                    }
                },
                {
                    "targets": 6,
                    "render": function (data, type, row) {
                if(row.target>0){
                    var $achieved = Math.round(row.achieved/row.target * 100,2);
                }else{
                    var $achieved = Math.round(row.achieved,2);
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
                      return 30;
                    }
                }
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
       var paths=@json($paths);
       var initiatives=@json($initiatives);
       var users=@json($users);
       var projects=@json($projects);
       var categories=@json($categories);

        $(function() {
            $('#type').change(function () {
                targetType();
            });

        });

        function targetType() {
            var type = $("#type").val();
            var html='';
            $('#section_id').html('');
            if(type==1){
                initiatives.forEach(element => {
                    html+='<option value="'+element.id+'">'+element.text+'</option>';
                });
                $('#section_id').html(html);
            }
            if(type==2){
                paths.forEach(element => {
                    html+='<option value="'+element.id+'">'+element.text+'</option>';
                });
                $('#section_id').html(html);
            }
            if(type==3){
                users.forEach(element => {
                    html+='<option value="'+element.id+'">'+element.text+'</option>';
                });
                $('#section_id').html(html);
            }
            if(type==4){
                projects.forEach(element => {
                    html+='<option value="'+element.id+'">'+element.text+'</option>';
                });
                $('#section_id').html(html);
            }
            if(type==5){
                categories.forEach(element => {
                    html+='<option value="'+element.id+'">'+element.text+'</option>';
                });
                $('#section_id').html(html);

            }
        }

    </script>
@endpush

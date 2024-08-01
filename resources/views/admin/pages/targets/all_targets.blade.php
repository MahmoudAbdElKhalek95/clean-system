@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.alltargets') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.alltargets') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-8 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 filter_type waves-effect" href="#" data-type="1">
                        <span class="active-sorting text-primary">{{ __('targets.type_1') }}</span>
                    </a>
                    <a class="btn btn-sm btn-outline-primary me-1 filter_type waves-effect" href="#" data-type="2">
                        <span class="active-sorting text-primary">{{ __('targets.type_2') }}</span>
                    </a>
                    <a class="btn btn-sm btn-outline-primary me-1 filter_type waves-effect" href="#" data-type="3">
                        <span class="active-sorting text-primary">{{ __('targets.type_3') }}</span>
                    </a>
                    <a class="btn btn-sm btn-outline-primary me-1 filter_type waves-effect" href="#" data-type="4">
                        <span class="active-sorting text-primary">{{ __('targets.type_4') }}</span>
                    </a>
                    <a class="btn btn-sm btn-outline-primary me-1 filter_type waves-effect" href="#" data-type="5">
                        <span class="active-sorting text-primary">{{ __('targets.type_5') }}</span>
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
                        <th>{{ __('targets.target_type') }}</th>
                        <th>{{ __('targets.target_name') }}</th>
                        <th>{{ __('admin.all_targets') }}</th>
                        <th>{{ __('admin.total_targets') }}</th>
                        <th>{{ __('targets.achieved') }}</th>
                        <th>{{ __('targets.percent') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<input type="hidden" name="type" id="type" value="1">
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
                url: "{{ route('targets.alllist') }}",
                data: function (d) {
                    d.type   = $('#type').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'type', name: 'type'},
                {data: 'section', name: 'section'},
                {data: 'all_targets', name: 'all_targets'},
                {data: 'total_targets', name: 'total_targets',orderable: false,searchable: false},
                {data: 'achieved', name: 'achieved',orderable: false,searchable: false},
                {data: 'percent',name: 'percent',orderable: false,searchable: false},
            ]


        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        $('.filter_type').click(function (){
            var type=$(this).attr('data-type');
            $("#type").val(type);
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

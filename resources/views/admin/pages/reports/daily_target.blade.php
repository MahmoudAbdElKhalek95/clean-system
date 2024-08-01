@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.dailyreport') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.dailyreport') }}</span>
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
                        <th>{{ __('targets.target_type') }}</th>
                        <th>{{ __('targets.target_name') }}</th>
                        <th>{{ __('targets.day') }}</th>
                        <th>{{ __('targets.target') }}</th>
                        <th>{{ __('targets.achieved') }}</th>
                        <th>{{ __('targets.percent') }}</th>
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
            searching: false,
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
                url: "{{ route('daily.target') }}",
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
                {data: 'day', name: 'day'},
                {data: 'target', name: 'target'},
                {data: 'achieved', name: 'achieved'},
                {data: 'percent',name: 'percent',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": 5,
                    "render": function (data, type, row) {

                        var $achieved = Math.round(row.achieved/row.target * 100,2);
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
            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

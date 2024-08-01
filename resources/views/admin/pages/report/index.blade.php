@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.links_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-3">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.links_report') }}</span>
                    </h1>
                </div>
                <div class="col-md-9 card">
                    <div class="card-body">
                        <form action="" class="row">
                            <div class="col-md-5">
                                <input type="text" name="datef" id="datef" class="form-control flatpickr-range" placeholder="المدة من" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="datet" id="datet" class="form-control flatpickr-range" placeholder="المدة الى" required>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-outline-primary bg-white me-1 waves-effect border-0 btn_filter" type="submit" >
                                    <i data-feather='zoom-in'></i>
                                    <span class="active-sorting text-primary">{{ __('links.search') }}</span>
                                </button>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-4 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">

                @include('admin.pages.report.filter')

            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('links.date') }}</th>
                        <th>{{ __('links.links_numbers') }}</th>
                        <th>{{ __('links.total') }}</th>
                        <th>{{ __('admin.links_percent') }}</th>
                        <th>{{ __('links.percent') }}</th>
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
                url: "{{ route('links-report.list') }}",
                data: function (d) {
                    d.from   = $('#filterForm #from').val();
                    d.to     = $('#filterForm #to').val();
                    d.category_id=$("#category_id").val();
                    d.project_id=$("#project_id").val();
                    d.filter_date=$("#filter_date").val();
                    d.datef=$("#datef").val();
                    d.datet=$("#datet").val();

                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'date', name: 'date',orderable: false,searchable: false},
                {data: 'count', name: 'count',orderable: false,searchable: false},
                {data: 'total', name: 'total',orderable: false,searchable: false},
                {data: 'percent', name: 'percent',orderable: false,searchable: false},
                {data: 'diffrence', name: 'diffrence',orderable: false,searchable: false},
            ],
             columnDefs: [
                {
                    "targets": -5,
                    "render": function (data, type, row,meta) {
                        var row_number= meta.settings._iDisplayStart + meta.row + 1;
                        if($("#datef").val() && $("#datet").val()){
                            if(row_number==1){
                                return $("#datef").val();
                            }else{
                                return $("#datet").val();

                            }
                        }
                        return row.date;
                    }
                },
                {
                    "targets": -2,
                    "render": function (data, type, row,meta) {
                        var row_number= meta.settings._iDisplayStart + meta.row + 1;

                        if($("#datef").val() && $("#datet").val()&& row.percent.includes("percent1")){
                            var percent1=JSON.parse(row.percent).percent1;
                            var percent2=JSON.parse(row.percent).percent2;
                            var percent=0;
                            if(row_number==1){
                                percent =percent1;
                            }else{
                                    percent =percent2;
                                }
                                if (percent >= 100) {
                                    return `<button class="btn btn-sm btn-outline-success me-1 waves-effect"> ${percent-100}%</button>`;
                                } else {
                                    return `<button class="btn btn-sm btn-outline-danger me-1 waves-effect">${100-percent}%</button>`;
                            }
                        }
                        return row.percent;
                    }
                },
                {
                    "targets": -1,
                    "render": function (data, type, row,meta) {
                        var row_number= meta.settings._iDisplayStart + meta.row + 1;
                        console.log(row.diffrence);
                        if($("#datef").val() && $("#datet").val() && row.percent.includes("percent1")){
                              var count1=JSON.parse(row.diffrence).count1;
                              var count2=JSON.parse(row.diffrence).count2;
                            if(row_number==1){
                                return count1;
                            }else{
                                return count2;
                            }

                        }
                        return row.diffrence
                    }
                },
            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });

    $(window).on('load', function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $(document).on('change', '#category_id', function(){
                var category_id = $(this).val();
                $("#project_id").empty();
                $("#project_id").select2({
                ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {results: data};
                    },
                    cache: true,
                    url: function () {
                    return "{{ route('projects.selectNumber') }}?category_id="+category_id;
                    }
                }
            });
        });


});
    </script>

@endpush

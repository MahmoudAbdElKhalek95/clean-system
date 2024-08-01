@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.project_donors_report') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.project_donors_report') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                     <div class="mb-1 col-md-12  @error('project_id') is-invalid @enderror">
                            <label style="    float: inline-start;" class="form-label" for="project_id">{{ __('links.project') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('projects.selectNumber') }}"
                            data-ajax--cache="true"  >
                            </select>
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
                        <th>{{ __('links.phone') }}</th>
                        <th>{{ __('links.doner_type') }}</th>
                        <th>{{ __('links.lastdate') }}</th>
                        <th>{{ __('links.lasttotal') }}</th>
                        <th> عدد مرات التبرع   </th>
                        <th> اجمالي مبالغ التبرع  </th>
                        <th> عدد مرات التبرع للمشاريع الاخري</th>
                        <th> اجمالي مبالغ لتبرع للمشاريع الاخري</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop


@push('scripts')

     <script type="text/javascript">
    $(document).ready(function() {
    var table = $('.datatables-ajax').DataTable( {
        "columns": [
             {data: 'phone', name: 'phone'},
            {data: 'doner_type', name: 'doner_type'},
            {data: 'date', name: 'date'},
            {data: 'lasttotal', name: 'lasttotal'},
            {data: 'count_amount', name: 'count_amount'},
            {data: 'total', name: 'total'},
            {data: 'other_project_count', name: 'other_project_count'},
            {data: 'other_project_sum', name: 'other_project_sum'}
        ]
    } );

    $(document).on('change', '#project_id', function(){
      table.destroy();
          table = $('.datatables-ajax').DataTable( {
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
             url: "{{ route('projectDonor.report') }}",
               data: function (d) {
                    d.project_id   = $('#project_id').val();
                }
         },
         drawCallback: function (settings) {
                feather.replace();
            },
        columns: [
            {data: 'phone', name: 'phone'},
            {data: 'other_project_count', name: 'other_project_count.doner_type',orderable: false,searchable: false},
            {data: 'data_total', name: 'data_total.date',orderable: false,searchable: false},
            {data: 'data_total', name: 'data_total.total',orderable: false,searchable: false},
            {data: 'number_of_operations', name: 'number_of_operations'},
            {data: 'total', name: 'total'},
            {data: 'other_project_count', name: 'other_project_count.other_operations',orderable: false,searchable: false},
            {data: 'other_project_count', name: 'other_project_count.other_total',orderable: false,searchable: false},
        ],
        columnDefs: [
                {
                    "targets": -5,
                    "render": function (data, type, row) {
                        var total=JSON.parse(row.data_total);
                        return total.total;
                    }
                },
                {
                    "targets": -6,
                    "render": function (data, type, row) {
                        var date=JSON.parse(row.data_total);
                        return date.date;
                    }
                },
                {
                    "targets": -2,
                    "render": function (data, type, row) {
                        var total=JSON.parse(row.other_project_count);
                        return total.other_operations;
                    }
                },
                {
                    "targets": -1,
                    "render": function (data, type, row) {
                        var total=JSON.parse(row.other_project_count);
                        return total.other_total;
                    }
                },
                {
                    "targets": -7,
                    "render": function (data, type, row) {
                        var total=JSON.parse(row.other_project_count);
                        return total.doner_type;
                    }
                }
            ]
    } );
    })
} );

    </script>
@endpush



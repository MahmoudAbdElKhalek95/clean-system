@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('qrcode_messages.plural') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('qrcode_messages.plural') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-primary me-1 waves-effect" href="{{ route('qrcode_messages.create') }}">
                        <i data-feather="plus"></i>
                        <span class="active-sorting text-primary">ارسال</span>
                    </a>
                        @include('admin.pages.qrcode_messages.import')

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
                        <th>{{ __('qrcode_messages.name') }}</th>
                        <th>{{ __('qrcode_messages.serial_number') }}</th>
                        <th>{{ __('qrcode_messages.phone') }}</th>
                        <th>{{ __('qrcode_messages.used_phone') }}</th>
                        <th>{{ __('qrcode_messages.status') }}</th>
                        {{-- <th width="15%" class="text-center">{{ __('qrcode_messages.options') }}</th> --}}
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
                url: "{{ route('qrcode_messages.list') }}",
                data: function (d) {
                    d.name   = $('#filterForm #name').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'name', name: 'name'},
                {data: 'serial_number', name: 'serial_number'},
                {data: 'phone', name: 'phone'},
                {data: 'used_phone', name: 'used_phone'},
                {data: 'status', name: 'status'},
                ],
            columnDefs: [


            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

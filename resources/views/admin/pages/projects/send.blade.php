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
                        @include('admin.pages.projects.filtersend')

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
                        <th>{{ __('projects.number_donor') }}</th>
                        <th>{{ __('projects.sendstatus') }}</th>
                        <th width="15%" class="text-center">{{ __('projects.options') }}</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="modalSend" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="sendForm" method="post" action="{{ route('projects.resendProjects') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">{{ __('admin.dialogs.send.title') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="main_project_id" id="main_project_id">
                       <div class="mb-1 col-md-12  @error('project_id') is-invalid @enderror">
                            <label class="form-label" for="project_id">{{ __('projects.name') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('projects.select') }}"
                                    data-ajax--cache="true" >
                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('admin.dialogs.send.confirm') }}</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">{{ __('admin.dialogs.send.cancel') }}</button>
                </div>
            </div>
        </form>
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
                url: "{{ route('projects.sendProjects') }}",
                data: function (d) {
                    d.category_id   = $('#filterForm #category_id').val();
              
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'code', name: 'code'},
                {data: 'name', name: 'name'},
                {data: 'category', name: 'category'},
                {data: 'number_donor', name: 'number_donor',searchable: false},
                {data: 'sendstatus', name: 'send_status'},
                {data: 'actions',name: 'actions',orderable: false,searchable: false},
            ],
            columnDefs: [
                {
                    "targets": -1,
                    "render": function (data, type, row) {
                        return `<button class="btn btn-sm btn-outline-success me-1 waves-effect send_item" data-id="`+row.id+`" href="#"><i data-feather="send"></i></button>`;
                    }
                },
            ],
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        $('body').on('click', '.send_item', function (){
            var id= $(this).attr('data-id');
            $('#main_project_id').val(id)
            $('#modalSend').modal('show')
            return false;
        });
    </script>
@endpush

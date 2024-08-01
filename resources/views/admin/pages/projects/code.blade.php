@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('projects.actions.updatecode') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('projects.actions.updatecode') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
            <div class="row">

                <div class="mb-1 breadcrumb-right col-md-6" >
                    <div class="dropdown">

                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card" style="padding: 2%">
          <form method='post' enctype="multipart/form-data"  id="jquery-val-form" action="{{  route('projects.updatecode') }}">
            @csrf
            <div class="row ">
                <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                    <label class="form-label" for="project_id">{{ __('projects.singular2') }}</label>
                    <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('projects.select') }}"
                            data-ajax--cache="true"  required >
                    </select>
                    @error('project_id')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                    <label class="form-label">{{ __('projects.code') }}</label>
                    <input class="form-control" name="code" type="text" value="{{  old('code') }}" required>
                    @error('code')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-1 col-md-2">
                    <br>
                    <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                        <i data-feather="save"></i>
                        <span class="active-sorting text-primary">{{ __('projects.actions.save') }}</span>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('projects.singular2') }}</th>
                        <th>{{ __('projects.code') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin') }}/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
@endpush
@push('scripts')
  <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/admin') }}/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script>
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: true,
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [[10, 50, 100,500, -1], [10, 50, 100,500, "All"]],
                buttons: [
                {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                    extend: 'print',
                    text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                    className: 'dropdown-item',
                    exportOptions: { columns: [0,1] }
                    },
                    {
                    extend: 'excel',
                    text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                    className: 'dropdown-item',
                    exportOptions: { columns: [0,1] }
                    },

                    {
                    extend: 'copy',
                    text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1,2] }
                    }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                    $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
                },

            ],
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('projects.code') }}",
                data: function (d) {
                    d.code   = $('#filterForm #code').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'project', name: 'project'},
                {data: 'code', name: 'code'}
            ],

        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });

    </script>
@endpush

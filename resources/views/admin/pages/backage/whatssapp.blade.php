@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('users.actions.whatssetting') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('users.actions.whatssetting') }}</span>
                        <span>{{ $item->name }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-12 col-12 d-md-block ">
            <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
                action="{{ route('categories.savewhatsapp') }}">
                <input type="hidden" name="category_id" value="{{ $item->id }}">
                @csrf
                <div class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                                <i data-feather="save"></i>
                                <span class="active-sorting text-primary">{{ __('users.actions.save') }}</span>
                            </button>
                            <div class="row">

                                <div class="mb-1 col-md-2  @error('percent') is-invalid @enderror">
                                    <label class="form-label">{{ __('users.percent') }}</label>
                                    <input class="form-control" name="percent" type="text" value="{{ $item->percent ?? old('percent') }}">
                                    @error('percent')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-1 col-md-7  @error('message') is-invalid @enderror">
                                    <label class="form-label">{{ __('users.message') }}</label>
                                    <textarea class="form-control" rows="1" name="message" >{{ old('message') }}</textarea>
                                    @error('message')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('users.category') }}</th>
                        <th>{{ __('users.percent') }}</th>
                        <th>{{ __('users.message') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" id="category_id" value="{{ $item->id }}">
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
                url: "{{ route('categories.whatsapp',['id',$item->id]) }}",
                data: function (d) {
                    d.category_id   = $('#category_id').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                {data: 'category', name: 'category'},
                {data: 'percent', name: 'percent'},
                {data: 'message', name: 'message'},
            ]
        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
    </script>
@endpush

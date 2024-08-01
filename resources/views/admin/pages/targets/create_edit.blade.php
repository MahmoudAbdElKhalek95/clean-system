@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('targets.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('targets.update', $item->id) : route('targets.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('targets.actions.edit') : __('targets.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('targets.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('target') is-invalid @enderror">
                            <label class="form-label">{{ __('targets.target') }}</label>
                            <input class="form-control" name="target" type="number" value="{{ $item->target ?? old('target') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        
                        <div class="mb-1 col-md-4  @error('date_type') is-invalid @enderror">
                            <label class="form-label" for="date_type">{{ __('targets.date_type') }}</label>
                            <select name="date_type" id="date_type" class="form-control" onchange="">
                                    <option value="1" @isset($item) {{ $item->date_type==1?'selected':'' }} @endisset >{{__('targets.daily') }}</option>
                                    <option value="2" @isset($item)  {{ $item->date_type==2?'selected':'' }}  @endisset>{{__('targets.period') }}</option>

                            </select>
                            @error('date_type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 day_section @error('day') is-invalid @enderror" style=" @isset($item) {{ $item->date_type==2? 'display: none':''}} @endisset ">
                            <label class="form-label">{{ __('targets.day') }}</label>
                            <input class="form-control" name="day" type="date" value="{{ $item->day ?? old('day') }}">
                            @error('day')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 period_section @error('date_from') is-invalid @enderror" @if(!isset($item) || $item->type==1) style="display: none" @endif>
                            <label class="form-label">{{ __('targets.date_from') }}</label>
                            <input class="form-control" name="date_from" type="date" value="{{ $item->date_from ?? old('date_from') }}">
                            @error('date_from')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 period_section @error('date_to') is-invalid @enderror" @if(!isset($item) || $item->type==1) style="display: none" @endif>
                            <label class="form-label">{{ __('targets.date_to') }}</label>
                            <input class="form-control" name="date_to" type="date" value="{{ $item->date_to ?? old('date_to') }}">
                            @error('date_to')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('targets.type') }}</label>
                            <select name="type" id="type" class="form-control" onchange="">
                                <option value="1"@isset($item)  {{ $item->type==1?'selected':'' }}  @endisset>{{__('targets.model_types.1') }}</option>
                                <option value="2"@isset($item)  {{ $item->type==2?'selected':'' }}  @endisset>{{__('targets.model_types.2') }}</option>
                                <option value="3"@isset($item)  {{ $item->type==3?'selected':'' }}  @endisset>{{__('targets.model_types.3') }}</option>
                                <option value="4"@isset($item)  {{ $item->type==4?'selected':'' }}  @endisset>{{__('targets.model_types.4') }}</option>
                                <option value="5"@isset($item)  {{ $item->type==5?'selected':'' }}  @endisset>{{__('targets.model_types.5') }}</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('archive_id') is-invalid @enderror target_type_section" >
                            <label class="form-label" for="archive_id">{{ __('targets.archive') }}</label>
                            <select name="archive_id" id="archive_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('archives.select') }}"
                                    data-ajax--cache="true" >
                                @isset($item->archive)
                                    <option value="{{ $item->archive->id }}" selected> {{ $item->archive->name }} </option>
                                @endisset
                            </select>
                            @error('archive_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('show_in_statistics') is-invalid @enderror">
                             <div class="form-check">
                                <br>
                                    <input class="form-check-input" type="checkbox" value="1" id="show_in_statistics" name="show_in_statistics" {{ isset($item) ? $item->show_in_statistics==1 ? 'checked' : '' : '' }} tabindex="3" style="height: 40px;width: 40px;" />
                                    <label class="form-check-label" for="show_in_statistics" style="margin-right: 10px;font-size: 25px;"> {{ __('targets.show_in_statistics') }} </label>
                                </div>
                            @error('show_in_statistics')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('section_id') is-invalid @enderror">
                            <label class="form-label" for="section_id">{{ __('targets.target_type') }}</label>
                            <select name="section_id" id="section_id" class="form-control " required>
                                @isset($item->section)
                                    <option value="{{ $item->section_id }}" selected>{{ $item->section?$item->section->name:'' }}</option>
                                @endisset
                            </select>
                            @error('section_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@push('scripts')
    <script>
    $(window).on('load', function() {
        targetType();
    });
            var paths=@json($paths);
            var initiatives=@json($initiatives);
            var users=@json($users);
            var projects=@json($projects);
            var categories=@json($categories);
        $(function() {
            $('#date_type').change(function () {
                var date_type = $(this).val();
                if(date_type==1){
                    $('.day_section').show(1000);
                    $('.period_section').hide(1000);
                }else{
                    $('.day_section').hide(1000);
                    $('.period_section').show(1000);
                }
            })
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

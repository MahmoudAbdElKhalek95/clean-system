@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('initiatives.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('initiatives.update', $item->id) : route('initiatives.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('initiatives.actions.edit') : __('initiatives.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('initiatives.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('name') is-invalid @enderror">
                            <label class="form-label">{{ __('initiatives.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('targets.type') }}</label>
                            <select name="type" id="type" class="form-control" >
                                <option value="1"@isset($item)  {{ $item->type==1?'selected':'' }}  @endisset>{{__('initiatives.model_types.1') }}</option>
                                <option value="2"@isset($item)  {{ $item->type==2?'selected':'' }}  @endisset>{{__('initiatives.model_types.2') }}</option>
                                <option value="3"@isset($item)  {{ $item->type==3?'selected':'' }}  @endisset>{{__('initiatives.model_types.3') }}</option>

                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror code_section" style="display: none">
                            <label class="form-label">{{ __('initiatives.code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ $item->code ?? old('code') }}">
                            @error('code')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror category_section" style="display: none">
                            <label class="form-label" for="category_id">{{ __('initiatives.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('categories.select') }}"
                                    data-ajax--cache="true"   >
                                @isset($item->category)
                                    <option value="{{ $item->category->id }}" selected>{{ $item->category->name }}</option>
                                @endisset
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror project_section" style="display: none">
                            <label class="form-label" for="project_id">{{ __('initiatives.project') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('projects.select') }}"
                                    data-ajax--cache="true"   >
                                @isset($item->project)
                                    <option value="{{ $item->project->id }}" selected>{{ $item->project->name }}</option>
                                @endisset
                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('path_id') is-invalid @enderror">
                            <label class="form-label" for="path_id">{{ __('initiatives.path') }}</label>
                            <select name="path_id" id="path_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('paths.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->path)
                                    <option value="{{ $item->path->id }}" selected>{{ $item->path->name }}</option>
                                @endisset
                            </select>
                            @error('path_id')
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
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@push('scripts')
    <script>
            $(window).on('load', function() {
                changeType();
            });

        $(function() {

            $('#type').change(function () {
                changeType();
            });

        });

        function changeType() {
            var type = $("#type").val();
            if(type==1){
                $('.code_section').show(1000);
                $('.category_section').hide(1000);
                $('.project_section').hide(1000);
            }
            if(type==2){
                $('.code_section').hide(1000);
                $('.category_section').show(1000);
                $('.project_section').hide(1000);
            }
            if(type==3){
                $('.code_section').hide(1000);
                $('.category_section').hide(1000);
                $('.project_section').show(1000);
            }
        }

    </script>
@endpush

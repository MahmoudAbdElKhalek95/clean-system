@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('projects.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('projects.update', $item->id) : route('projects.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('projects.actions.edit') : __('projects.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('projects.actions.save') }}</span>
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
                            <label class="form-label">{{ __('projects.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                            <label class="form-label">{{ __('projects.code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ $item->code ?? old('code') }}">
                            @error('code')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('not_active') is-invalid @enderror">
                             <div class="form-check">
                                <br>
                                    <input class="form-check-input" type="checkbox" value="1" id="not_active" name="not_active" {{ isset($item) ? $item->not_active==1 ? 'checked' : '' : '' }} tabindex="3" style="height: 40px;width: 40px;" />
                                    <label class="form-check-label" for="not_active" style="margin-right: 10px;font-size: 25px;"> {{ __('projects.active') }} </label>
                                </div>
                            @error('not_active')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('projects.category') }}</label>
                            <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('categories.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->category)
                                    <option value="{{ $item->category->id }}" selected>{{ $item->category->name }}</option>
                                @endisset
                            </select>
                            @error('category_id')
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

@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.category_phones') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('category_phones.update', $item->id) : route('category_phones.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('categories.actions.edit') : __('categories.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('categories.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">

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

                        <div class="mb-1 col-md-4  @error('phone_numbers') is-invalid @enderror">
                            <label class="form-label">{{ __('admin.phone_number') }}</label>
                            <input class="form-control" name="phone_numbers" type="text" value="{{ $item->phone_numbers ?? old('phone_numbers') }}">
                            @error('phone_numbers')
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

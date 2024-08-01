@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('categories.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('categories.update', $item->id) : route('categories.store') }}">
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
                        <div class="mb-1 col-md-4  @error('name') is-invalid @enderror">
                            <label class="form-label">{{ __('categories.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('category_number') is-invalid @enderror">
                            <label class="form-label">{{ __('categories.category_number') }}</label>
                            <input class="form-control" name="category_number" type="text" value="{{ $item->category_number ?? old('category_number') }}">
                            @error('category_number')
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
                        <div class="mb-1 col-md-4  @error('phone_id') is-invalid @enderror">
                            <label class="form-label" for="phone_id">{{ __('projects.phone') }}</label>
                            <select name="phone_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('whatsapp_phones.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->phone)
                                    <option value="{{ $item->phone->id }}" selected>{{ $item->phone->name }}</option>
                                @endisset
                            </select>
                            @error('phone_id')
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

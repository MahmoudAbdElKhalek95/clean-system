@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('doners.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('doners.update', $item->id) : route('doners.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('doners.actions.edit') : __('doners.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('doners.actions.save') }}</span>
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
                            <label class="form-label">{{ __('doners.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('phone') is-invalid @enderror">
                            <label class="form-label">{{ __('doners.phone') }}</label>
                            <input class="form-control" name="phone" type="number" value="{{ $item->phone ?? old('phone') }}">
                            @error('phone')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('amounts') is-invalid @enderror">
                            <label class="form-label">{{ __('doners.amounts') }}</label>
                            <input class="form-control" name="amounts" type="number" value="{{ $item->amounts ?? old('amounts') }}">
                            @error('amounts')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('doner_type_id') is-invalid @enderror">
                            <label class="form-label" for="doner_type_id">{{ __('doners.donerType') }}</label>
                            <select name="doner_type_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('doner_types.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->donerType)
                                    <option value="{{ $item->donerType->id }}" selected>{{ $item->donerType->name }}</option>
                                @endisset
                            </select>
                            @error('doner_type_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
@stop

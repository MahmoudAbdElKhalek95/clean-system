@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sections.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('sections.update', $item->id) : route('sections.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('sections.actions.edit') : __('sections.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('sections.actions.save') }}</span>
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
                            <label class="form-label">{{ __('sections.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                            <label class="form-label">{{ __('sections.code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ $item->code ?? old('code') }}">
                            @error('code')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('section_type') is-invalid @enderror">
                            <label class="form-label" for="section_type">{{ __('targets.section_key') }}</label>
                            <select name="section_type" id="section_type" class="form-control" required>
                                <option value="1" @isset($item) {{ $item->section_type == 1 ? 'selected' : '' }} @endisset>{{ __('sections.types.1') }}</option>
                                <option value="2" @isset($item) {{ $item->section_type == 2 ? 'selected' : '' }} @endisset>{{ __('sections.types.2') }}</option>
                            </select>
                            @error('section_type')
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

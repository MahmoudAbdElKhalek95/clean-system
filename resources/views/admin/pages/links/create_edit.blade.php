@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('links.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ route('links.store') }}">
        <input type="hidden" name="_method" value="POST">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('links.actions.edit') : __('links.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('links.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('amount') is-invalid @enderror">
                            <label class="form-label">{{ __('links.amount') }}</label>
                            <input class="form-control" name="amount" type="number" value="{{ old('amount') }}">
                            @error('amount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('price') is-invalid @enderror">
                            <label class="form-label">{{ __('links.price') }}</label>
                            <input class="form-control" name="price" type="number" value="{{ $item->price ?? old('price') }}">
                            @error('price')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                            <label class="form-label" for="project_id">{{ __('links.project') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('projects.select') }}"
                            data-ajax--cache="true"  required >
                            @isset($item->project)
                                    <option value="{{ $item->project->id }}" selected>{{ $item->project->name }}</option>
                            @endisset
                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="mb-1 col-md-4  @error('section_id') is-invalid @enderror">
                            <label class="form-label" for="section_id">{{ __('links.section') }}</label>
                            <select name="section_id" id="section_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('sections.select') }}"
                            data-ajax--cache="true" >
                            @isset($item->section)
                                    <option value="{{ $item->section->id }}" selected>{{ $item->section->name }}</option>
                            @endisset
                            </select>
                            @error('section_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        {{-- <div class="mb-1 col-md-4  @error('user_id') is-invalid @enderror">
                            <label class="form-label" for="user_id">{{ __('links.user') }}</label>
                            <select name="user_id" id="user_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('users.selectClient') }}"
                            data-ajax--cache="true"   >
                            @isset($item->user)
                                    <option value="{{ $item->user->id }}" selected>{{ $item->user->name }}</option>
                                @endisset
                            </select>
                            @error('user_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="mb-1 col-md-4  @error('phone') is-invalid @enderror">
                            <label class="form-label">{{ __('links.phone') }}</label>
                            <input class="form-control" name="phone" type="number" value="{{ $item->phone ?? old('phone') }}">
                            @error('phone')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('date') is-invalid @enderror">
                            <label class="form-label">{{ __('links.date') }}</label>
                            <input class="form-control" name="date" type="date" value="{{ $item->date ?? old('date') }}">
                            @error('date')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                            <label class="form-label">{{ __('links.code') }}</label>
                            <input class="form-control" name="code" type="code" value="{{ $item->code ?? old('code') }}">
                            @error('code')
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

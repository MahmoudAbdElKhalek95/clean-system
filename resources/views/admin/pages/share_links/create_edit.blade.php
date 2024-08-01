@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.share_links') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('share_links.update', $item->id) : route('share_links.store') }}">
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
                            <label class="form-label">{{ __('admin.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                            <label class="form-label" for="project_id">{{ __('admin.project_id') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('projects.select') }}"
                                    data-ajax--cache="true"  required >
                               @foreach ( App\Models\Project::get() as $item )
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('admin.type') }}</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="1" @isset($item) {{ $item->type == 1 ? 'selected' : '' }} @endisset>{{ __('admin.sharetypes.1') }}</option>
                                <option value="2" @isset($item) {{ $item->type == 2 ? 'selected' : '' }} @endisset>{{ __('admin.sharetypes.2') }}</option>
                            </select>
                            @error('type')
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

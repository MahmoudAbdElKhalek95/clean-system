@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('workers.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('workers.update', $item->id) : route('workers.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('workers.actions.edit') : __('workers.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('workers.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                       

                        <div class="mb-1 col-md-4  @error('school_id') is-invalid @enderror">
                            <label class="form-label" for="school_id">{{ __('workers.school_id') }}</label>
                            <select name="school_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('school.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->school)
                                    <option value="{{ $item->school->id }}" selected>{{ $item->school->name }}</option>
                                @endisset
                            </select>
                            @error('school_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                            <label class="form-label" for="project_id">{{ __('workers.project_id') }}</label>
                            <select name="project_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('contract.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->project)
                                    <option value="{{ $item->project->id }}" selected>{{ $item->project->name }}</option>
                                @endisset
                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('name') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.name') }}</label>
                            <input class="form-control" name="name" name="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('national_id') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.national_id') }}</label>
                            <input class="form-control" name="national_id" national_id="text" value="{{ $item->national_id ?? old('national_id') }}">
                            @error('national_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('job') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.job') }}</label>
                            <input class="form-control" name="job" job="text" value="{{ $item->job ?? old('job') }}">
                            @error('job')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('job_place') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.job_place') }}</label>
                            <input class="form-control" name="job_place" job_place="text" value="{{ $item->job_place ?? old('job_place') }}">
                            @error('job_place')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('company') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.company') }}</label>
                            <input class="form-control" name="company" company="text" value="{{ $item->company ?? old('company') }}">
                            @error('company')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('salary') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.salary') }}</label>
                            <input class="form-control" name="salary" salary="text" value="{{ $item->salary ?? old('salary') }}">
                            @error('salary')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        

                        <div class="mb-1 col-md-4  @error('status') is-invalid @enderror">
                            <label class="form-label">{{ __('workers.status') }}</label>
                            <select class="form-control" name="status" status="text" >
                           <option value="work" {{{isset($item )&& $item->status == 'work'? 'selected' : '' }}} >قيد العمل</option>
                           <option value="holiday" {{{isset($item )&& $item->status == 'holiday'? 'selected' : '' }}} > اجازه  </option>
                           <option value="not_deserve"  {{{ isset($item )&& $item->status == 'not_deserve'? 'selected' : '' }}} > لا يستحق</option>

                            </select>
                             @error('status')
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

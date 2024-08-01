@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('school.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('school.update', $item->id) : route('school.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('school.actions.edit') : __('school.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('school.actions.save') }}</span>
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
                            <label class="form-label">{{ __('school.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('school_number') is-invalid @enderror">
                            <label class="form-label">{{ __('school.school_number') }}</label>
                            <input class="form-control" name="school_number" type="text" value="{{ $item->school_number ?? old('school_number') }}">
                            @error('school_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('region') is-invalid @enderror">
                            <label class="form-label">{{ __('school.region') }}</label>
                            <input class="form-control" name="region" type="text" value="{{ $item->region ?? old('region') }}">
                            @error('region')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('city') is-invalid @enderror">
                            <label class="form-label">{{ __('school.city') }}</label>
                            <input class="form-control" name="city" type="text" value="{{ $item->city ?? old('city') }}">
                            @error('city')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('state') is-invalid @enderror">
                            <label class="form-label">{{ __('school.state') }}</label>
                            <input class="form-control" name="state" type="text" value="{{ $item->state ?? old('state') }}">
                            @error('state')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('spcilization') is-invalid @enderror">
                            <label class="form-label">{{ __('school.spcilization') }}</label>
                            <input class="form-control" name="spcilization" type="text" value="{{ $item->spcilization ?? old('spcilization') }}">
                            @error('spcilization')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('class_number') is-invalid @enderror">
                            <label class="form-label">{{ __('school.class_number') }}</label>
                            <input class="form-control" name="class_number" type="text" value="{{ $item->class_number ?? old('class_number') }}">
                            @error('class_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('pathromm_number') is-invalid @enderror">
                            <label class="form-label">{{ __('school.pathromm_number') }}</label>
                            <input class="form-control" name="pathromm_number" type="text" value="{{ $item->pathromm_number ?? old('pathromm_number') }}">
                            @error('pathromm_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('google_map_link') is-invalid @enderror">
                            <label class="form-label">{{ __('school.google_map_link') }}</label>
                            <input class="form-control" name="google_map_link" type="text" value="{{ $item->google_map_link ?? old('google_map_link') }}">
                            @error('google_map_link')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                      
                        <div class="mb-1 col-md-4  @error('manager_name') is-invalid @enderror">
                            <label class="form-label">{{ __('school.manager_name') }}</label>
                            <input class="form-control" name="manager_name" type="text" value="{{ $item->manager_name ?? old('manager_name') }}">
                            @error('manager_name')
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

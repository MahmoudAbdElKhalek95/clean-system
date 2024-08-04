@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('visit.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('visit.update', $item->id) : route('visit.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('visit.actions.edit') : __('visit.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('visit.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{--  <div class="mb-1 col-md-4  @error('supervisior_name') is-invalid @enderror">
                            <label class="form-label">{{ __('visit.supervisior_name') }}</label>
                            <input class="form-control" name="supervisior_name" type="text" value="{{ $item->supervisior_name ?? old('supervisior_name') }}">
                            @error('supervisior_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  --}}

                        <div class="mb-1 col-md-4  @error('user_id') is-invalid @enderror">
                            <label class="form-label" for="user_id">{{ __('visit.supervisior_name') }}</label>
                            <select name="user_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('users.selectClient') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->user)
                                    <option value="{{ $item->user->id }}" selected>{{ $item->user->name }}</option>
                                @endisset
                            </select>
                            @error('user_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('visit_number') is-invalid @enderror">
                            <label class="form-label">{{ __('visit.visit_number') }}</label>
                            <input class="form-control" name="visit_number" visit_number="text" value="{{ $item->visit_number ?? old('visit_number') }}">
                            @error('visit_number')
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

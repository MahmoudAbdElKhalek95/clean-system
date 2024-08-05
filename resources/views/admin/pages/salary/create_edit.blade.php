@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('salary.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('salary.update', $item->id) : route('salary.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('salary.actions.edit') : __('salary.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('salary.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="mb-1 col-md-4  @error('worker_id') is-invalid @enderror">
                            <label class="form-label" for="worker_id">{{ __('salary.worker_id') }}</label>
                            <select name="worker_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('workers.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->worker)
                                    <option value="{{ $item->worker->id }}" selected>{{ $item->worker->name }}</option>
                                @endisset
                            </select>
                            @error('worker_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
{{--  
                        <div class="mb-1 col-md-4  @error('month') is-invalid @enderror">
                            <label class="form-label">{{ __('salary.month') }}</label>
                            <input class="form-control" name="month" type="text" value="{{ $item->month ?? old('month') }}">
                            @error('month')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  --}}
                        <div class="mb-1 col-md-4  @error('salary') is-invalid @enderror">
                            <label class="form-label">{{ __('salary.salary') }}</label>
                            <input class="form-control" name="salary" type="text" value="{{ $item->salary ?? old('salary') }}">
                            @error('salary')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('month') is-invalid @enderror">
                            <label class="form-label">{{ __('salary.month') }}</label>
                            <select class="form-control" name="month" month="text" >
                           <option value="1" {{{isset($item )&& $item->month == '1'? 'selected' : '' }}} > يناير</option>
                           <option value="2" {{{isset($item )&& $item->month == '2'? 'selected' : '' }}} > فبراير  </option>
                           <option value="3"  {{{ isset($item )&& $item->month == '3'? 'selected' : '' }}} >  مارس</option>
                           <option value="4"  {{{ isset($item )&& $item->month == '4'? 'selected' : '' }}} >  ابريل</option>
                           <option value="5"  {{{ isset($item )&& $item->month == '5'? 'selected' : '' }}} >  مايو</option>
                           <option value="6"  {{{ isset($item )&& $item->month == '6'? 'selected' : '' }}} >  يونيو</option>
                           <option value="7"  {{{ isset($item )&& $item->month == '7'? 'selected' : '' }}} >  يوليو</option>
                           <option value="8"  {{{ isset($item )&& $item->month == '8'? 'selected' : '' }}} >  اغسطس</option>
                           <option value="9"  {{{ isset($item )&& $item->month == '9'? 'selected' : '' }}} >  سبتمبر</option>
                           <option value="10"  {{{ isset($item )&& $item->month == '10'? 'selected' : '' }}} >  اكنوبر</option>
                           <option value="11"  {{{ isset($item )&& $item->month == '11'? 'selected' : '' }}} >  نوفمبر</option>
                           <option value="12"  {{{ isset($item )&& $item->month == '12'? 'selected' : '' }}} >  ديسمبر</option>
                            </select>
                             @error('month')
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

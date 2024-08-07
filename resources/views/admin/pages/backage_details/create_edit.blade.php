@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('backage_details.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('backage_details.update', $item->id) : route('backage_details.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('backage_details.actions.edit') : __('backage_details.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('backage_details.actions.save') }}</span>
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
                            <label class="form-label" for="school_id">{{ __('backage_details.school_id') }}</label>
                            <select name="school_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('school.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->subject)
                                    <option value="{{ $item->subject->id }}" selected>{{ $item->subject->name }}</option>
                                @endisset
                            </select>
                            @error('school_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('backage_id') is-invalid @enderror">
                            <label class="form-label" for="backage_id">{{ __('backage_details.backage_id') }}</label>
                            <select name="backage_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('backage.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->subject)
                                    <option value="{{ $item->subject->id }}" selected>{{ $item->subject->name }}</option>
                                @endisset
                            </select>
                            @error('backage_id')
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

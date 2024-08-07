@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('backage.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('backage.update', $item->id) : route('backage.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('backage.actions.edit') : __('backage.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('backage.actions.save') }}</span>
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
                            <label class="form-label">{{ __('backage.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  

                        <div class="mb-1 col-md-4  @error('subject_id') is-invalid @enderror">
                            <label class="form-label" for="subject_id">{{ __('backage.subject_id') }}</label>
                            <select name="subject_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('subject.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->subject)
                                    <option value="{{ $item->subject->id }}" selected>{{ $item->subject->name }}</option>
                                @endisset
                            </select>
                            @error('subject_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    
                        <div class="mb-1 col-md-4  @error('quantity') is-invalid @enderror">
                            <label class="form-label">{{ __('backage.quantity') }}</label>
                            <input class="form-control" name="quantity" type="text" value="{{ $item->quantity ?? old('quantity') }}">
                            @error('quantity')
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

@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('client.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('client.update', $item->id) : route('client.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('client.actions.edit') : __('client.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('client.actions.save') }}</span>
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
                            <label class="form-label">{{ __('client.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('phone') is-invalid @enderror">
                            <label class="form-label">{{ __('client.phone') }}</label>
                            <input class="form-control" name="phone" type="text" value="{{ $item->phone ?? old('phone') }}">
                            @error('phone')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-1 col-md-4  @error('type_id') is-invalid @enderror">
                            <label class="form-label" for="type_id">{{ __('client.type_id') }}</label>
                            <select name="type_id" id="type_id" class="form-control ajax_select2 extra_field" multiple
                                    data-ajax--url="{{ route('type.select') }}"
                                    data-ajax--cache="true"  required >
                                {{--  @if ( !empty($item->category() ))
                                    <option value="{{ $item->category() }}" selected>{{ $item->category() }}</option>
                                @endif  --}}
                            </select>
                            @error('type_id')
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

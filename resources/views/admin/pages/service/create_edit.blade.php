@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('service.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('service.update', $item->id) : route('service.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('service.actions.edit') : __('service.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('service.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-6  @error('name') is-invalid @enderror">
                            <label class="form-label">{{ __('service.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('type') is-invalid @enderror">
                            <label class="form-label">{{ __('service.type') }}</label>
                            <input class="form-control" name="type" type="text" value="{{ $item->type ?? old('type') }}">
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{--  <div class="mb-1 col-md-4  @error('status') is-invalid @enderror">
                            <label class="form-label">{{ __('service.status') }}</label>
                            <input class="form-control" name="status" type="text" value="{{ $item->status ?? old('status') }}">
                            @error('status')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  --}}


                        {{--  <div class="mb-1 col-md-4  @error('status') is-invalid @enderror">
                            <div class="form-check">
                               <br>
                               <label class="form-check-label" for="status" style="margin-right: 10px;font-size: 25px;"> {{ __('service.status') }} </label>

                                   <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ isset($item) ? $item->status==1 ? 'checked' : '' : '' }} tabindex="3" style="height: 40px;width: 40px;" />
                               </div>
                           @error('status')
                           <span class="error">{{ $message }}</span>
                           @enderror
                       </div>  --}}

                       <hr>
                       <div class="mb-1 col-md-6  @error('status') is-invalid @enderror">
                            <div class="row">
                                <div class="col-md-2">
                                <label class="form-label">{{ __('service.status') }}</label>
                                </div>
                                <div class="col-md-3">
                                  <input  type="radio" id="active" name="status" value="active">
                                  <label   for="active"> فعال </label><br>
                                </div>
                                <div class="col-md-3">
                                  <input   type="radio" id="not_active" name="status" value="not_active">
                                  <label  for="not_active"> غير فعال  </label><br>
                                </div>
                       @error('status')
                       <span class="error">{{ $message }}</span>
                       @enderror
                     </div>
                    </div>

                    
                    

                  
                      
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('contract.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('contract.update', $item->id) : route('contract.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('contract.actions.edit') : __('contract.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('contract.actions.save') }}</span>
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
                            <label class="form-label">{{ __('contract.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('number') is-invalid @enderror">
                            <label class="form-label">{{ __('contract.number') }}</label>
                            <input class="form-control" name="number" type="text" value="{{ $item->number ?? old('number') }}">
                            @error('number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('start_date') is-invalid @enderror">
                            <label class="form-label">{{ __('contract.start_date') }}</label>
                            <input class="form-control" name="start_date" type="date" value="{{ $item->start_date ?? old('start_date') }}">
                            @error('start_date')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('end_date') is-invalid @enderror">
                            <label class="form-label">{{ __('contract.end_date') }}</label>
                            <input class="form-control" name="end_date" type="date" value="{{ $item->end_date ?? old('end_date') }}">
                            @error('end_date')
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

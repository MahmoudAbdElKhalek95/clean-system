@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('archives.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('archives.update', $item->id) : route('archives.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('archives.actions.edit') : __('archives.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('archives.actions.save') }}</span>
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
                            <label class="form-label">{{ __('archives.targettype') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-1 col-md-6  @error('amount') is-invalid @enderror">
                            <label class="form-label">{{ __('archives.amount') }}</label>
                            <input class="form-control" name="amount" type="number" value="{{ $item->amount ?? old('amount') }}">
                            @error('amount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('start') is-invalid @enderror">
                            <label class="form-label">{{ __('archives.start') }}</label>
                            <input class="form-control flatpickr-basic" name="start" value="{{ $item->start ?? old('start') }}">
                            @error('start')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('end') is-invalid @enderror">
                            <label class="form-label">{{ __('archives.end') }}</label>
                            <input class="form-control flatpickr-basic"  name="end" value="{{ $item->end ?? old('end') }}">
                            @error('end')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

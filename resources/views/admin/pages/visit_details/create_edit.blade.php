@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('visit_details.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('visit_details.update', $item->id) : route('visit_details.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('visit_details.actions.edit') : __('visit_details.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('visit_details.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="visit_id" value="1">
                     
                        <div class="mb-1 col-md-4  @error('user_id') is-invalid @enderror">
                            <label class="form-label" for="user_id">{{ __('visit_details.supervisior_name') }}</label>
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

                        {{--  <div class="mb-1 col-md-4  @error('vist_id') is-invalid @enderror">
                            <label class="form-label" for="vist_id">{{ __('visit_details.visit_id') }}</label>
                            <select name="vist_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('visit.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->visit)
                                    <option value="{{ $item->visit->id }}" selected>{{ $item->visit->name }}</option>
                                @endisset
                            </select>
                            @error('vist_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  --}}

                        <div class="mb-1 col-md-4  @error('school_id') is-invalid @enderror">
                            <label class="form-label" for="school_id">{{ __('visit_details.school_id') }}</label>
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

                        <div class="mb-1 col-md-4  @error('day') is-invalid @enderror">
                            <label class="form-label">{{ __('visit_details.day') }}</label>
                            <input class="form-control" name="day" type="text" value="{{ $item->day ?? old('day') }}">
                            @error('day')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('date') is-invalid @enderror">
                            <label class="form-label">{{ __('visit_details.date') }}</label>
                            <input class="form-control" name="date" type="date" value="{{ $item->date ?? old('date') }}">
                            @error('date')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('time') is-invalid @enderror">
                            <label class="form-label">{{ __('visit_details.time') }}</label>
                            <input class="form-control" name="time" type="time" value="{{ $item->time ?? old('time') }}">
                            @error('time')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('rate') is-invalid @enderror">
                            <label class="form-label">{{ __('visit_details.rate') }}</label>
                            <input class="form-control" name="rate" type="text" value="{{ $item->rate ?? old('rate') }}">
                            @error('rate')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('note') is-invalid @enderror">
                            <label class="form-label">{{ __('visit_details.note') }}</label>
                            <input class="form-control" name="note" type="text" value="{{ $item->note ?? old('note') }}">
                            @error('note')
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

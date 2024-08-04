@extends('admin.layouts.Rate_master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('rate.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('rate.update', $item->id) : route('rate.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('rate.actions.edit') : __('rate.plural') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('rate.actions.save') }}</span>
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
                            <label class="form-label">{{ __('rate.supervisior_name') }}</label>
                            <input class="form-control" name="supervisior_name" type="text" value="{{ $item->supervisior_name ?? old('supervisior_name') }}">
                            @error('supervisior_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>  --}}

                        <input type="hidden" name="super_id" value="{{$visit_details->user_id ?? null }}">
                        <input type="hidden" name="manager_id"value="{{$visit_details->school->manager->id ?? null   }}">
                        <input type="hidden" name="visit_detail_id" value="{{$visit_details->id  ?? null }}">


                    
                        <div class="mb-1 col-md-4  @error('rate_employee_performance') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_employee_performance') }}</label>
                            <select class="form-control" name="rate_employee_performance"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_employee_performance')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('rate_excuted_time') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_excuted_time') }}</label>
                            <select class="form-control" name="rate_excuted_time"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_excuted_time')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('rate_contious_visit') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_contious_visit') }}</label>
                            <select class="form-control" name="rate_contious_visit"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_contious_visit')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('rate_service') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_service') }}</label>
                            <select class="form-control" name="rate_service"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_service')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('rate_company') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_company') }}</label>
                            <select class="form-control" name="rate_company"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_company')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('rate_service_statisfied') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_service_statisfied') }}</label>
                            <select class="form-control" name="rate_service_statisfied"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_service_statisfied')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="mb-1 col-md-4  @error('rate_service_statisfied_range') is-invalid @enderror">
                            <label class="form-label">{{ __('rate.rate_service_statisfied_range') }}</label>
                            <select class="form-control" name="rate_service_statisfied_range"   >
                             <option value="1"> 1 </option>
                             <option value="2"> 2 </option>
                             <option value="3"> 3 </option>
                             <option value="4"> 4 </option>
                             <option value="5"> 5 </option>
                            
                            </select>
                              @error('rate_service_statisfied_range')
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

@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('doner_types.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('doner_types.update', $item->id) : route('doner_types.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('doner_types.actions.edit') : __('doner_types.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('doner_types.actions.save') }}</span>
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
                            <label class="form-label">{{ __('doner_types.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('doner_types.type') }}</label>
                            <select name="type"  id ="type" class="form-control  extra_field"
                                     required >
                                <option value="" selected> اختر  </option>
                                <option value="money" {{  ( @!empty($item->type) && $item->type ) ==  "money" ? 'selected' : '' }} > مبالغ  </option>
                                <option value="link"  {{  (@!empty($item->type) && $item->type ) ==  "link"  ? 'selected' : '' }} > عمليات </option>

                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div    @if ( isset($item) && $item->type == 'money' )  style="display:block"  @else style=" display:none"  @endif    id = "from"  class="mb-1 col-md-6 @error('from') is-invalid @enderror">
                            <label class="form-label">{{ __('doner_types.from') }}</label>
                            <input class="form-control" name="from" type="number" value="{{ $item->from ?? old('from') }}">
                            @error('from')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <di    @if  ( isset($item) && $item->type == 'money' )  style="display:block"  @else style=" display:none"  @endif   id ="to"    class="mb-1 col-md-6  @error('to') is-invalid @enderror">
                            <label class="form-label">{{ __('doner_types.to') }}</label>
                            <input class="form-control" name="to" type="number" value="{{ $item->to ?? old('to') }}">
                            @error('to')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    
                    

                        <div    @if ( isset($item) && $item->type == 'link' )  style="display:block"  @else style=" display:none"  @endif   id ="link_from" class="mb-1 col-md-6  @error('link_from') is-invalid @enderror">
                            <label class="form-label">{{ __('doner_types.link_from') }}</label>
                            <input class="form-control" name="link_from" type="text" value="{{ $item->link_from ?? old('link_from') }}">
                            @error('from')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div  @if ( isset($item) && $item->type == 'link' )  style="display:block"  @else style=" display:none"  @endif    id ="link_to" class="mb-1 col-md-6  @error('link_to') is-invalid @enderror">
                            <label class="form-label">{{ __('doner_types.link_to') }}</label>
                            <input class="form-control" name="link_to" type="text" value="{{ $item->link_to ?? old('link_to') }}">
                            @error('link_to')
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
@push('scripts')
<script>
$(window).on('load', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#type").change(function(){
     // alert("The text has been changed.");
      let value = $("#type").val() ;
     // alert(  value ) ;
      if( value == "money" )
      {
            $("#from").show() ;
            $("#to").show() ;
            $("#link_from").hide() ;
            $("#link_to").hide() ;

      }else{

         $("#from").hide() ;
         $("#to").hide() ;
         $("#link_from").show() ;
          $("#link_to").show() ;

      }
    });

});


    </script>

@endpush


@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('compain.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('compain.update', $item->id) : route('compain.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('compain.actions.edit') : __('compain.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('compain.actions.save') }}</span>
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
                            <label class="form-label">{{ __('compain.name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ $item->name ?? old('name') }}">
                            @error('name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                            <label class="form-label">{{ __('compain.code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ $item->code ?? old('code') }}">
                            @error('code')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('targets') is-invalid @enderror">
                            <label class="form-label" for="targets">{{ __('compain.targets') }}</label>
                            <select name="targets"  id ="targets" class="form-control  extra_field"
                                     required >

                                <option value="null" selected> اختر  </option>
                                <option value="project_donor" {{  ( @!empty($item->targets) && $item->targets ) ==  "project_donor" ? 'selected' : '' }} >  متبرعي المشاريع  </option>
                                <option value="donor_type"  {{  (@!empty($item->targets) && $item->targets ) ==  "twitter"  ? 'selected' : '' }} > اقسام المتبرعين </option>
                                <option value="client"  {{  (@!empty($item->targets) && $item->targets ) ==  "client"  ? 'selected' : '' }} >  جماهير الجمعية </option>

                            </select>
                            @error('targets')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        @if( is_null( $item-> project_id ) == false ) 

                        <div id ="category" class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('compain.category_id') }}</label>
                            <select name="category_id[]" id="category_id" class="form-control ajax_select2 extra_field" multiple
                                    data-ajax--url="{{ route('categories.select') }}"
                                    data-ajax--cache="true"   >
                              
                                @foreach (  $item->categories as $cat )
                                <option value="{{ $cat->id  }}" selected>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        @endif



                        @if( is_null( $item-> project_id ) == false ) 
                        <div   id ="project" class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                            <label class="form-label" for="project_id">{{ __('compain.project_id') }}</label>
                            <select name="project_id[]" id="project_id"  class="form-control ajax_select2 extra_field" multiple
                                    data-ajax--cache="true"

                                     >
                                     @foreach (  $item->projectss as $pro )
                                     <option value="{{ $pro->id }}" selected>{{ $pro->name }}</option>
                                     @endforeach

                            </select>
                            @error('project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif


                        <div class="mb-1 col-md-4  @error('marketing_project_id') is-invalid @enderror">
                            <label class="form-label" for="marketing_project_id">{{ __('compain.marketing_project_id') }}</label>
                            <select name="marketing_project_id"  id="marketing_project_id"  class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('projects.select') }}"
                            
                            data-ajax--cache="true"  required >
                              
                            @if (   is_null($item->marketing_projectss ) == false   )
                            <option value="{{ $item->marketing_project->id }}" selected>{{ $item->marketing_project->name }}</option>
                            @endif
                              
                            </select>
                            @error('marketing_project_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-1 col-md-4  @error('amount') is-invalid @enderror">
                            <label class="form-label">{{ __('compain.amount') }}</label>
                            <input class="form-control" name="amount" type="text" value="{{ $item->amount ?? old('amount') }}">
                            @error('amount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>




                        @if( is_null( $item-> target_type_id ) == false ) 

                        <div  id = "target_type_id" class="mb-1 col-md-4  @error('target_type_id') is-invalid @enderror">
                            <label class="form-label" for="target_type_id">{{ __('compain.target_type_id') }}</label>
                            <select name="target_type_id[]" multiple id="" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('type.select') }}"
                                    data-ajax--cache="true"   >
                             
                                    @if( is_null(  $item->target_types )  == false )
                                    @foreach (  $item->target_types as $type )
                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                    @endforeach
                                    @endif


                            </select>
                            @error('target_type_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif

                        @if( is_null( $item-> target_doner_type_id ) == false ) 

                        <div  id = "donor_type" class="mb-1 col-md-4  @error('target_doner_type_id') is-invalid @enderror">
                            <label class="form-label" for="target_doner_type_id">{{ __('compain.target_doner_type_id') }}</label>
                            <select name="target_doner_type_id[]" multiple id="target_doner_type_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('doner_types.select') }}"
                                    data-ajax--cache="true"   >
                                    @if( is_null(  $item->target_doner_types )  == false )
                                    @foreach (  $item->target_doner_types as $type )
                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                    @endforeach
                                    @endif


                            </select>
                            @error('target_doner_type_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif


                        @if( is_null( $item-> sending_way ) == false) 
                        <div class="mb-1 col-md-4  @error('sending_way') is-invalid @enderror">
                            <label class="form-label" for="sending_way">{{ __('compain.sending_way') }}</label>
                            <select name="sending_way"  id ="sending_way" class="form-control  extra_field"
                                     required >

                                <option value="" selected> اختر  </option>
                                <option value="whatsApp" {{  ( @!empty($item->sending_way) && $item->sending_way ) ==  "whatsApp" ? 'selected' : '' }} > whatsApp  </option>
                                <option value="twitter"  {{  (@!empty($item->sending_way) && $item->sending_way ) ==  "twitter"  ? 'selected' : '' }} > twitter </option>
                                <option value="facebook"   {{  ( @!empty($item->sending_way) &&  $item->sending_way ) ==  "facebook" ? 'selected' : '' }} > facebook </option>


                            </select>
                            @error('sending_way')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif

                    @if( is_null( $item-> whatsapp_template ) == false) 
                    <div   id = "whatsapp_template"  class="mb-1 col-md-4  @error('whatsapp_template') is-invalid @enderror">
                        <label class="form-label" for="whatsapp_template">{{ __('whatsapps.message') }}</label>
                        <select name="whatsapp_template"  class="form-control ajax_select2 extra_field"
                                data-ajax--url="{{ route('sending_templates.select') }}"
                                data-ajax--cache="true"   >
                            @isset($item->whatsapps)
                                <option value="{{ $item->whatsapps->id }}" selected>{{ $item->whatsapps->template_name }}</option>
                            @endisset
                        </select>
                        @error('whatsapp_template')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                    @endif

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
    $("#sending_way").change(function(){
     // alert("The text has been changed.");
      let value = $("#sending_way").val() ;
     // alert(  value ) ;
      if( value == "whatsApp" )
      {

            $("#whatsapp_template").show() ;
      }else{
          $("#whatsapp_template").hide() ;

      }
    });

     ///////////////////////////// targets /////

     $("#targets").change(function(){
        // alert("The text has been changed.");
         let value = $("#targets").val() ;
        // alert(  value ) ;
         if( value == "project_donor" )
         {
               $("#project_donor").show() ;
         }else{
             $("#donor_type").hide() ;

         }

         switch( value )
         {

            case "project_donor":
            $("#project_donor").show() ;
            $("#category").show() ;
            $("#project").show() ;
            $("#donor_type").hide() ;

            break;
          case "donor_type":
            $("#project_donor").hide() ;
            $("#category").hide() ;
            $("#project").hide() ;
            $("#donor_type").show() ;
            break;
            case "client":
            $("#project_donor").hide() ;
            $("#category").hide() ;
            $("#project").hide() ;
            $("#donor_type").hide() ;
            $("#target_type_id").show() ;

            break;

          default:
          $("#project_donor").hide() ;
          $("#donor_type").hide() ;
          $("#category").hide() ;
          $("#target_type_id").show() ;
          $("#project").hide() ;


         }

       });


     //////////////////////////////////////////

        $(document).on('change', '#category_id', function(){
                var category_id = $(this).val();
                $("#project_id").empty();
                $("#project_id").select2({
                ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {results: data};
                    },
                    cache: true,
                    url: function () {
                    return "{{ route('projects.select') }}?category_id="+category_id;
                    }
                }
            });

        });


});
    </script>

@endpush

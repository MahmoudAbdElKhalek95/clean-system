@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('sending_templates.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('sending_templates.update', $item->id) : route('sending_templates.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('sending_templates.actions.edit') : __('sending_templates.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('sending_templates.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-6  @error('template_name') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.template_name') }}</label>
                            <input class="form-control" name="template_name" type="text" value="{{ $item->template_name ?? old('template_name') }}">
                            @error('template_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-6  @error('var_number') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.var_number') }}</label>
                            <input class="form-control" id ="var_number" name="var_number" type="text" value="{{ $item->var_number ?? old('var_number') }}">
                            @error('var_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <div class="row">

                        <div class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                            <label class="form-label" for="var">{{ __('sending_templates.var') }}</label>
                            <select name="var"  id ="var" class="form-control  extra_field"
                                      >
                             
                                <option value="" selected> اختر  </option>
                                <option value="project_name" > {{ __('sending_templates.project_name') }}  </option>
                                <option value="project_link"   > {{ __('sending_templates.project_link') }}  </option>
                                <option value="project_percent"  > {{ __('sending_templates.project_percent') }}  </option>


                            </select>
                            @error('var')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>
                      
                        <div class="row">
                        <div style=" display:{{ empty($item->project_name ) ? 'none' :'block'}} "  id = "project_name"  class="mb-1 col-md-4  @error('project_name') is-invalid @enderror">
                            <label class="form-label" for="project_name">{{ __('sending_templates.project_name') }}</label>
                            <input class="form-control" name="project_name" type="hidden" value="{{ $item->project_name ?? 'project_name' }}">
                            @error('project_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div style="display:{{ empty($item->project_link ) ? 'none' :'block'}} " id = "project_link"  class="mb-1 col-md-4  @error('project_link') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.project_link') }}</label>
                            <input class="form-control" name="project_link" type="hidden" value="{{ $item->project_link ?? 'project_link' }}">
                            @error('project_link')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display:{{ empty($item->project_percent ) ? 'none' :'block'}} "  id = "project_percent"  class="mb-1 col-md-4  @error('project_percent') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.project_percent') }}</label>
                            <input class="form-control" name="project_percent" type="hidden" value="{{ $item->project_percent ?? 'project_percent'  }}">
                            @error('project_percent')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        </div>
                     

                        <div class="row">
                        <div class="mb-1 col-md-6  @error('photo_question') is-invalid @enderror">
                            <label class="form-label" for="photo_question"> هل يوجد صوره ؟ </label>
                            <select  id ="photo_question" name="photo_question"  class="form-control "
                                       >
                                    <option value="">اختر  </option>
                                    <option value="yes" > نعم  </option>
                                    <option value="no" >  لا  </option>

                            </select>
                            @error('photo_question')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  style="display: none;"  id = "photo" class="mb-1 col-md-6  @error('photo') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.photo') }}</label>
                            <input class="form-control" name="photo" type="file" >
                            @error('photo')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>

                        <div class="row">

                        <div class="mb-1 col-md-6  @error('video_question') is-invalid @enderror">
                            <label class="form-label" for="video_question"> هل يوجد فديو ؟ </label>
                            <select  id = "video_question" name="video_question"  class="form-control "
                                       >
                                    <option value="">اختر  </option>
                                    <option value="yes" > نعم  </option>
                                    <option value="no" >  لا  </option>

                            </select>
                            @error('video_question')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  style="display: none;"  id = "video" class="mb-1 col-md-6  @error('video') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.video') }}</label>
                            <input class="form-control" name="video" type="file" >
                            @error('video')
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
        ///////////////// photo //////////
        $("#photo_question").change(function(){
         // alert("The text has been changed.");
          let value = $("#photo_question").val() ;
         // alert(  value ) ;
          if( value == "yes" )
          {
    
                $("#photo").show() ;
          }else{
              $("#photo").hide() ;
    
          }
        });

           ///////////////// photo //////////
           $("#photo_question").change(function(){
            // alert("The text has been changed.");
             let value = $("#photo_question").val() ;
            // alert(  value ) ;
             if( value == "yes" )
             {
       
                   $("#photo").show() ;
             }else{
                 $("#photo").hide() ;
       
             }
           });

             ///////////////// video //////////
             $("#video_question").change(function(){
                // alert("The text has been changed.");
                 let value = $("#video_question").val() ;
                // alert(  value ) ;
                 if( value == "yes" )
                 {
                       $("#video").show() ;
                 }else{
                     $("#video").hide() ;
           
                 }
               });
    
         ///////////////////////////// varsabiles  /////
    
         let count = 0 ; 
         let arr = [] ;
         $("#var").change(function(){
            // alert("The text has been changed.");
              count = count + 1 ;
             let value = $("#var").val() ;
             let var_number = $("#var_number").val() ;
            // alert(var_number) ;

             alert(  count ) ;

             if(  var_number == 0 || var_number == null   )
             {
                alert(' عدد المتغيرات مطلوب ')
                count = 0 ;
             }
             if( count > var_number  )
             {
                alert('لقد تجاوزت عدد المتغيرات الممسوح بها ')
             }

             if(  count <= var_number  && count > 1 &&   arr.includes(value) == true   )
             {
                 count = count-1 ;
             }
    
             if( count != 0 &&  count <=  var_number  )
             {
                arr.push( value );
               // alert( arr ) ;
              // count = count + 1 ;


             switch( value )
             {
    
                case "project_name":
                $("#project_name").show() ;
               // $("#project_link").hide() ;
               // $("#project_percent").hide() ;
    
                break;
              case "project_link":
               // $("#project_name").hide() ;
                $("#project_link").show() ;
               // $("#project_percent").hide() ;
    
                break;
                case "project_percent":
               // $("#project_name").hide() ;
                //$("#project_link").hide() ;
                $("#project_percent").show() ;
                break;
             
              default:
              $("#project_name").hide() ;
              $("#project_link").hide() ;
              $("#project_percent").hide() ;
    
             } // end switch 
            } // end if 
             
           }); // end on change event 
    
    
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
    
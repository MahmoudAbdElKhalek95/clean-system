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
                @php

                $count = 0 ;
                @endphp
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-6  @error('template_name') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.template_name') }}</label>
                            <input class="form-control" name="template_name" type="text" value="{{ $item->template_name ?? old('template_name') }}">
                            @error('template_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div  class="mb-1 col-md-6  @error('var_number') is-invalid @enderror">
                            <label class="form-label">{{ __('sending_templates.var_number') }}</label>
                            <input class="form-control" id ="var_number" name="var_number" type="number" value="{{ $item->var_number ?? old('var_number') }}">
                            @error('var_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <div class="row">

                        <div  style=" display:{{ empty($item ) ? 'none' :'block'}} " id ="var1"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                            <label class="form-label" for="var"> المتغير الاول  </label>
                            <select name="param[]"   id ="var11" class="form-control  extra_field"
                                      >

                                {{--  <option value="" selected> اختر  </option>  --}}
                                <option value="null">اختر  </option>
                                <option value="project_name" > {{ __('sending_templates.project_name') }}  </option>
                                <option value="project_link"   > {{ __('sending_templates.project_link') }}  </option>
                                <option value="project_percent"  > نسبه المشروع الحالي  </option>
                                <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>



                            </select>
                            @error('var')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div    style=" display:{{ empty($item ) ? 'none' :'block'}} "  id ="var2"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                            <label class="form-label" for="var"> المتغير الثاني   </label>
                            <select name="param[]"   id ="var22" class="form-control  extra_field"
                                      >

                                {{--  <option value="" selected> اختر  </option>  --}}
                                <option value="null">اختر  </option>
                                <option value="project_name" > {{ __('sending_templates.project_name') }}  </option>
                                <option value="project_link"   > {{ __('sending_templates.project_link') }}  </option>
                                <option value="project_percent"  > نسبه المشروع الحالي  </option>
                                <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>


                            </select>
                            @error('var')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div     style=" display:{{ empty($item ) ? 'none' :'block'}} "  id ="var3"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                            <label class="form-label" for="var"> المتغير الثالث   </label>
                            <select name="param[]"   id ="var33" class="form-control  extra_field"
                                      >

                                {{--  <option value="" selected> اختر  </option>  --}}
                                <option value="null">اختر  </option>
                                <option value="project_name"  > {{ __('sending_templates.project_name') }}  </option>
                                <option value="project_link"  > {{ __('sending_templates.project_link') }}  </option>
                                <option value="project_percent"   > نسبه المشروع الحالي  </option>
                                <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>


                            </select>
                            @error('var')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        </div>
                        {{-- secound     --}}


                        <div class="row">

                            <div  style=" display:{{ empty($item ) ? 'none' :'block'}} " id ="var4"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                                <label class="form-label" for="var"> المتغير الرابع  </label>
                                <select name="param[]"   id ="var44" class="form-control  extra_field"
                                          >

                                    {{--  <option value="" selected> اختر  </option>  --}}
                                    <option value="null">اختر  </option>
                                    <option value="project_name" > {{ __('sending_templates.project_name') }}  </option>
                                    <option value="project_link"   > {{ __('sending_templates.project_link') }}  </option>
                                    <option value="project_percent"  > نسبه المشروع الحالي  </option>
                                    <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>



                                </select>
                                @error('var')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div    style=" display:{{ empty($item ) ? 'none' :'block'}} "  id ="var5"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                                <label class="form-label" for="var"> المتغير الخامس   </label>
                                <select name="param[]"   id ="var55" class="form-control  extra_field"
                                          >

                                    {{--  <option value="" selected> اختر  </option>  --}}
                                    <option value="null">اختر  </option>
                                    <option value="project_name" > {{ __('sending_templates.project_name') }}  </option>
                                    <option value="project_link"   > {{ __('sending_templates.project_link') }}  </option>
                                    <option value="project_percent"  > نسبه المشروع الحالي  </option>
                                    <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>


                                </select>
                                @error('var')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div     style=" display:{{ empty($item ) ? 'none' :'block'}} "  id ="var6"  class="mb-1 col-md-4  @error('var') is-invalid @enderror">
                                <label class="form-label" for="var"> المتغير السادس   </label>
                                <select name="param[]"   id ="var66" class="form-control  extra_field"
                                          >

                                    {{--  <option value="" selected> اختر  </option>  --}}
                                    <option value="null">اختر  </option>
                                    <option value="project_name"  > {{ __('sending_templates.project_name') }}  </option>
                                    <option value="project_link"  > {{ __('sending_templates.project_link') }}  </option>
                                    <option value="project_percent"   > نسبه المشروع الحالي  </option>
                                    <option value="remain_project_percent"  >  نسبه المشروع المتبقي  </option>


                                </select>
                                @error('var')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            </div>


                        {{--  ecound   --}}
                        {{--  <div class="row">
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
                            <label class="form-label">نسبه المشروع الحالي</label>
                            <input class="form-control" name="project_percent" type="hidden" value="{{ $item->project_percent ?? 'project_percent'  }}">
                            @error('project_percent')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        </div>
                       --}}

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

                            <div class="mb-1 col-md-6  @error('button') is-invalid @enderror">
                                <label class="form-label" for="button"> هل يوجد زر ؟ </label>
                                <select  id = "button" name="button"  class="form-control "
                                           >
                                        <option value="">اختر  </option>
                                        <option value="yes" > نعم  </option>
                                        <option value="no" >  لا  </option>

                                </select>
                                @error('button')
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
         $("#var_number").change(function(){
            // alert("The text has been changed.");

              count = count + 1 ;
            // let value = $("#var").val() ;
             let var_number = $("#var_number").val() ;
             // alert(var_number) ;

            // alert(var_number) ;

           //  alert(  count ) ;

             if(  var_number == 0 || var_number == null   )
             {
                alert(' عدد المتغيرات مطلوب ')
                count = 0 ;
             }

           /*  if(  var_number > 3     )
             {
                alert(' عدد المتغيرات لا يزيد عن 3  ')
                count = 0 ;
             }*/



             if( var_number == 1  )
             {
               // alert("one");
                $("#var1").show() ;
                $("#var2").hide() ;
                $("#var3").hide() ;
             }else if(  var_number == 2 )
             {
                //alert("two");
                $("#var1").show() ;
                $("#var2").show() ;
                $("#var3").hide() ;


             }else if( var_number == 3 )
             {
                $("#var1").show() ;
                $("#var2").show() ;
                $("#var3").show() ;

             }else if( var_number == 4 )
             {
                $("#var1").show() ;
                $("#var2").show() ;
                $("#var3").show() ;
                $("#var4").show() ;

             }else if( var_number == 5 )
             {
                $("#var1").show() ;
                $("#var2").show() ;
                $("#var3").show() ;
                $("#var4").show() ;
                $("#var5").show() ;

             }else if( var_number == 6 )
             {
                $("#var1").show() ;
                $("#var2").show() ;
                $("#var3").show() ;
                $("#var4").show() ;
                $("#var5").show() ;
                $("#var6").show() ;


             }








           }); // end on change event


         //////////////////////////////////////////



    });
        </script>

    @endpush
    
@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.project_report_uncompelte') }}</title>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="settings" class="font-medium-2"></i>
                        <span>{{ __('admin.project_report_uncompelte') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
            <div class="mb-1 breadcrumb-right">

            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
            <div class="row">
<div class="col-md-12">
    @isset($numbers)
    @if (count($numbers)>0)
    تم الارسال الى الارقام التاليه
    <ul class="alert alert-success">
        @foreach ($numbers as $number)
        <li>{{ $number }}</li>
        @endforeach
    </ul>
    @endif
    @endisset
</div>
               
                <div class="col-md-3">
                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=0'  }}">
                        <i data-feather="users"></i>
                        <span class="active-sorting text-primary">
                            {{  __('admin.project_report_uncompelte')  }}
                            <br> <br>
                             ( 0 ) 
                        </span>
                    </a>
                </div>
                  

              
                <div class="col-md-3">

                 <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=1'  }}">
                   <i data-feather="users"></i>
                   <span class="active-sorting text-primary">
                     {{ __('admin.project_report_uncompelte') }}  
                     <br> <br>
                     ( 1 - 10 )
                   </span>
                </a>
                </div>

                <div class="col-md-3">

                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=2'  }}">
                      <i data-feather="users"></i>
                      <span class="active-sorting text-primary">
                        {{ __('admin.project_report_uncompelte') }} 
                        <br> <br>
                        ( 11 - 20 )
                      </span>
                   </a>
                   </div>

                   <div class="col-md-3">

                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=3'  }}">
                      <i data-feather="users"></i>
                      <span class="active-sorting text-primary">
                        {{ __('admin.project_report_uncompelte') }} 
                        <br> <br>
                        ( 21 - 30 )
                      </span>
                   </a>
                   </div>

                   {{--  --}}
                   <hr style="margin-top: 25px;">

                   <div class="col-md-3">
                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=4'  }}">
                        <i data-feather="users"></i>
                        <span class="active-sorting text-primary">
                            {{ __('admin.project_report_uncompelte') }} 
                            <br> <br>
                            ( 31 - 40 )
                        </span>
                    </a>
                </div>
                  

              
                <div class="col-md-3">

                 <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=5'  }}">
                   <i data-feather="users"></i>
                   <span class="active-sorting text-primary">
                     {{ __('admin.project_report_uncompelte') }} 
                     <br> <br>
                     ( 41 - 50 )
                   </span>
                </a>
                </div>

                <div class="col-md-3">

                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=6'  }}">
                      <i data-feather="users"></i>
                      <span class="active-sorting text-primary">
                        {{ __('admin.project_report_uncompelte') }} 
                        <br> <br>
                        ( 51 - 60 )
                      </span>
                   </a>
                   </div>

                   <div class="col-md-3">

                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=7'  }}">
                      <i data-feather="users"></i>
                      <span class="active-sorting text-primary">
                        {{ __('admin.project_report_uncompelte') }} 

                        <br> <br>
                        ( 61 - 70 )
                      </span>
                   </a>
                   </div>

                   {{--  --}}

                   <hr style="margin-top: 25px;">
                   <div class="col-md-3">
                   <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=8'  }}">
                    <i data-feather="users"></i>
                    <span class="active-sorting text-primary">
                      {{ __('admin.project_report_uncompelte') }} 
                      <br> <br>
                      ( 71 - 80 )
                    </span>
                 </a>
                 </div>

                 <div class="col-md-3">

                  <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id)  .'?percent=9' }}">
                    <i data-feather="users"></i>
                    <span class="active-sorting text-primary">
                      {{ __('admin.project_report_uncompelte') }} 
                      <br> <br>
                      ( 81 - 90 )
                    </span>
                 </a>
                 </div>

                 <div class="col-md-3">

                    <a class="btn btn-outline-primary me-1 waves-effect" href="{{ route('UnCompleteCategoryProjectIndex' , $id) .'?percent=10'  }}">
                      <i data-feather="users"></i>
                      <span class="active-sorting text-primary">
                        {{ __('admin.project_report_uncompelte') }} 
                        <br> <br>
                        ( 91 - 100 )
                      </span>
                   </a>
                   </div>
              
              


        </div>

        </div>
        </div>
    </div>
@stop

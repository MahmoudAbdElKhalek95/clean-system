@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.dashboard') }}</title>
@endsection
@section('content')
    <div class="row match-height">

        <!-- Medal Card -->
        <div class="col-xl-4 col-md-6 col-12">
            <div class="card card-congratulation-medal">
                <div class="card-body">
                    <h5>{{ welcomeMessage() }} {{ auth()->user()->name }}</h5>
                    <p class="card-text font-small-3">{{ __('admin.hope_msg') }}</p>
                    <br>
                @if(auth()->user()->type!=\App\Models\User::TYPE_ADMIN)
                <h3 class="mb-75 mt-2 pt-50">
                    <p class="card-text font-small-3 mb-0">{{ __('admin.total_links',['archive'=>auth()->user()->targetType->name??'','amount'=> round($total_payments/3900,2),'total_amount'=>auth()->user()->target_amount]) }}</p>
                    <a href="#"></a>
                </h3>
                @else
                <h3 class="mb-75 mt-2 pt-50">
                    <p class="card-text font-small-3 mb-0">{{ __('admin.total_links',['archive'=>auth()->user()->targetType->name??'','amount'=> round($total_payments/3900,2),'total_amount'=>auth()->user()->target_amount]) }}</p>

                    <a href="#"></a>
                </h3>
                @endif
                 @if(auth()->user()->type==\App\Models\User::TYPE_CLIENT)

                @foreach ($progress_total_payments as $progress)
                    <div class="progress progress-bar-{{ $progress>74?'success':'primary' }}" style="height: auto;">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="{{ $progress }}" aria-valuemax="100" style="width: {{ $progress }}%">
                            {{ $progress }}%
                        </div>
                    </div>
                    <br>
                    @endforeach
                @endif

                    <img src="{{ asset('assets/admin') }}/images/illustration/badge.svg" class="congratulation-medal" alt="Medal Pic" />
                </div>
            </div>
        </div>
        <!--/ Medal Card -->

        <!-- Statistics Card -->
        <div class="col-xl-8 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.statistics') }}</h4>
                    <div class="d-flex align-items-center">
                        {{--                        <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p>--}}
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ round($total_payments,2) }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.total_payments') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ round($total_day,2) }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.total_day') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather="briefcase" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ round($totla_methods,2) }}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.totla_methods') }}</p>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i data-feather="archive" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ round($operation_day,2 )}}</h4>
                                    <p class="card-text font-small-3 mb-0">{{ __('admin.operation_day') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 @if(auth()->user()->type!=\App\Models\User::TYPE_CLIENT)
    <div class="row">
        @foreach ($paths as $path)

        <div class="col-lg-4 col-md-4 col-4">
            <div class="card earnings-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title mb-1">{{ $path->name }}</h4>
                            <div id="earnings-chart_{{ $path->id }}" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <canvas class="line-chart-ex chartjs" data-height="450"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{--  --}}

     @if(auth()->user()->type == \App\Models\User::TYPE_CLIENT)
    <div class="row">
        @foreach (  $share_links as $item )

        <div class="col-lg-4 col-md-4 col-4">

            <div class="card">
                <div class="card-header">

                    {{  $item->name  }}
                </div>
                <div class="card-body">

                    {{ $item->getLink() }}



                </div>
                <div class="card-footer">


                    <!-- The text field -->
                    <input type="text" style="display: none" value=" {{ $item->getLink() }}" id="{{ $item->id }}">

                    <!-- The button used to copy the text -->
                     <button class="btn btn-success"  onclick="myFunction( {{ $item->id }} )"> نسخ </button>





                </div>
            </div>

        </div>

        @endforeach



    </div>
    @endif



    {{--  --}}

@stop
@push('scripts')
<script src="{{ asset('assets/admin') }}/vendors/js/charts/apexcharts.min.js"></script>
<script src="{{ asset('assets/admin') }}/vendors/js/charts/chart.min.js"></script>
@include('admin.pages.dashboard.chart')

<<script>


 function myFunction( id ) {
  // Get the text field
  var copyText = document.getElementById( id );

  // Select the text field
  copyText.select() ;
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  // Alert the copied text
  //alert(" تم النسخ بنجاح  " );

  //alert("Copied the text: " + copyText.value);
}





</script>
@endpush

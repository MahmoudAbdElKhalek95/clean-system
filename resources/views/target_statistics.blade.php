@extends('admin.layouts.master2')
<?php $assetsPath = asset('assets/admin') ?>

@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.alltargets') }}</title>
@endsection

<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">


<link rel="stylesheet" href="{{ asset('numbers/css/style.css')  }}">
<style>
    html, body {
        /* background-color: #27b3c2; */
    }

    b{
    color: #fff ;
    text-decoration: none ;
}
</style>


@section('content')

{{--  --}}
<div class="container-fluid " style="background-color: #27b3c2;">
    <div style="row-gap: 50px;" class="row mt-5">
        <div class="col d-flex justify-content-center align-items-center">
            <img src="{{  asset('numbers/img/logo.png') }}" width="250" alt="">
        </div>
        <div class="col d-flex justify-content-center align-items-center">
            <img src="{{  asset('numbers/img/main-title.png') }}" width="300" alt="">
        </div>
    </div>

    <div class="row mt-5">
        {{-- <div class="col d-none d-lg-block"></div> --}}
        <div class="col col-lg-12">
            <div class="row">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('numbers/img/icons/shop.png') }}" width="38" alt="">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>إجمالي تبرعات</span>
                            <span>اليوم من المتجر</span>
                            <span class="text-light price-label position-absolute">
                                <b id="shop_today_total_donations" style="color:#fff !important ;   text-decoration: none ;"> {{ $total_shop_donations ?? 0  }} </b>
                                <span>ر.س</span>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-5">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('numbers/img/icons/cash-box.png')}}" width="38" alt="">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>أعلى مبلغ تبرع</span>
                            <span>لليوم من المتجر</span>
                            <span class="text-light price-label position-absolute">
                                <b id="shop_today_max_donations" style="color:#fff !important ;   text-decoration: none ;"> {{  $max_shop_donations ?? 0   }} </b>
                                <span>ر.س</span>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-5">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('numbers/img/icons/chart.png')}}" width="38" alt="">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>إجمالي المبالغ</span>
                            <span>من أصل {{ number_format($archive->amount??0) }}</span>
                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format($total_prices)  }}

                                    </b>
                                <span>ر.س</span>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('numbers/img/icons/dashboard.png')}}" width="54" alt="">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>مؤشر الحملة</span>
                            <span></span>
                            <span class="text-light price-label position-absolute">
                                <b>%</b>
                                <b id="donations_percent" style="color:#fff !important ;   text-decoration: none ;"> {{ $total_percent ?? 0  }} </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br>

        </div>
    </div>

    {{--  --}}


    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h1 class="bold mb-0 mt-1 text-dark">
                        <i data-feather="box" class="font-medium-2"></i>
                        <span>{{ __('admin.alltargets') }}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-end col-md-8 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect" href="{{ route('target_statistics').'?type=1' }}" data-type="1">
                        <span class="active-sorting text-default">{{ __('targets.type_1') }}</span>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="{{ route('target_statistics').'?type=2' }}" data-type="2">
                        <span class="active-sorting text-default">{{ __('targets.type_2') }}</span>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="{{ route('target_statistics').'?type=3' }}" data-type="3">
                        <span class="active-sorting text-default">{{ __('targets.type_3') }}</span>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="{{ route('target_statistics').'?type=4' }}" data-type="4">
                        <span class="active-sorting text-default">{{ __('targets.type_4') }}</span>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="{{ route('target_statistics').'?type=5' }}" data-type="5">
                        <span class="active-sorting text-default">{{ __('targets.type_5') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="content-body">



        <div class="card" style="background-color: #27b3c2">
            {{-- <div class="card-datatable table-responsive">
                <table class="dt-multilingual table datatables-ajax">
                    <thead>
                    <tr>
                        <th>{{ __('targets.target_type') }}</th>
                        <th>{{ __('targets.target_name') }}</th>

                        <th>{{ __('admin.total_targets') }}</th>
                        <th>{{ __('targets.achieved') }}</th>
                        <th>{{ __('targets.percent') }}</th>
                    </tr>
                    </thead>
                </table>
            </div> --}}

            <div class="row">
                @foreach (  $map as $item )
                <div class="col  col-lg-3 col-md-3 col-sm-2" style=" maragin-top:50px ; margin-bottom:50px  ">

                    {{-- <table  class="table table-bordered"  style="width: 100px ;height:100px ; border:2px solid black;" >
                        <tr>

                            <th colspan="2" class="text-center"> {{  $item['name'] }}</th>


                        </tr>
                        <tr>
                          <td>  {{ __('admin.targets') }} </td>
                          <td>  {{  __('targets.achieved')  }}  </td>

                        </tr>
                        <tr>
                          <td>  {{  $item['total_targets']   }}</td>
                          <td> {{  $item['total_achieved']   }}</td>

                        </tr>
                      </table> --}}
                      <div class="row mt-5">
                        <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('numbers/img/icons/cash-box.png')}}" width="38" alt="">
                                <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                                    <span style="color:black"> {{  $item['name'] }}  </span>
                                    {{-- <span style="color:black">    {{ __('admin.targets') }} </span> --}}
                                    <span style="color:black ">  {{ __('admin.target') }} : {{  $item['total_targets']   }} </span>
                                    {{-- <span class="text-light price-label position-absolute"   > --}}
                                        <span class="text-light price-label " style=" width: 150px;    margin-right: 10px; "   >

                                        <b id="shop_today_max_donations">  {{  $item['total_achieved']  ?? 0   }}  </b>
                                       <br>
                                        <span style="color:black;"> {{  __('targets.achieved')  }}  </span>
                                        {{-- <span>ر.س</span> --}}
                                        <span class="price-label-wrapper d-flex">

                                        </span>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                @endforeach

            </div>

        </div>
    </div>
    <br>

<input type="hidden" name="type" id="type" value="1">
@stop

@push('scripts')
<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script>
        var dt_ajax_table = $('.datatables-ajax');
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            info: true,
            lengthMenu: [[10, 50, 100,500, -1], [10, 50, 100,500, "All"]],
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            ajax: {
                url: "{{ route('alllist') }}",
                data: function (d) {
                    d.type   = $('#type').val();
                }
            },
            drawCallback: function (settings) {
                feather.replace();
            },
            columns: [
                {data: 'type', name: 'type'},
                {data: 'section', name: 'section'},
                // {data: 'all_targets', name: 'all_targets'},
                {data: 'total_targets', name: 'total_targets',orderable: false,searchable: false},
                {data: 'achieved', name: 'achieved',orderable: false,searchable: false},
                {data: 'percent',name: 'percent',orderable: false,searchable: false},
            ]


        });
        $('.btn_filter').click(function (){
            dt_ajax.DataTable().ajax.reload();
        });
        $('.filter_type').click(function (){
            var type=$(this).attr('data-type');
            $("#type").val(type);
            dt_ajax.DataTable().ajax.reload();
        });
    </script>

<script>

    $(document).ready(function(){

        setInterval(sendRequest, 60 * 1000 * 5); // every 5 minitues

        function sendRequest(){
            $.ajax({
            //url: "http://snabl.test/api/statistics",
            url: "https://justclick.net.sa/campaign-management/public/api/statistics",
            success:
                function(data){

               $('#shop_today_total_donations').text(data.data.total_shop_donations ? data.data.total_shop_donations : 0); //insert text of test.php into your div
                $('#shop_today_max_donations').text(data.data.max_shop_donations ? data.data.max_shop_donations : 0);
                $('#total_donations').text(data.data.total_prices ? numberWithCommas( data.data.total_prices ) : 0);
                $('#donations_percent').text(data.data.total_percent ? data.data.total_percent : 0);

            }

        });

        };

    });

    </script>
@endpush

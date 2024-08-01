@extends('admin.layouts.master2')
<?php $assetsPath = asset('assets/admin') ?>

@section('title')
    <title>{{ config('app.name') }} | {{ __('admin.alltargets') }}</title>
@endsection
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">

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
.dropdown {
  display: inline-block;
  position: relative;
}

.dd-button {
  display: inline-block;
  border: 1px solid gray;
  border-radius: 4px;
  padding: 10px 30px 10px 20px;
  background-color: #ffffff;
  cursor: pointer;
  white-space: nowrap;
}

.dd-button:after {
  content: '';
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid black;
}

.dd-button:hover {
  background-color: #eeeeee;
}


.dd-input {
  display: none;
}

.dd-menu {
  position: absolute;
  top: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0;
  margin: 2px 0 0 0;
  box-shadow: 0 0 6px 0 rgba(0,0,0,0.1);
  background-color: #ffffff;
  list-style-type: none;
  z-index: 99;
}

.dd-input + .dd-menu {
  display: none;
}

.dd-input:checked + .dd-menu {
  display: block;
}

.dd-menu li {
  padding: 10px 20px;
  cursor: pointer;
  white-space: nowrap;
}

.dd-menu li:hover {
  background-color: #f6f6f6;
}

.dd-menu li a {
  display: block;
  margin: -10px -20px;
  padding: 10px 20px;
}

.dd-menu li.divider{
  padding: 0;
  border-bottom: 1px solid #cccccc;
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
        <div class="col col-lg-6">
            <div class="row  mt-5">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                      <span>إجمالي المشاريع</span>
                        <span id="total_projects">
                            <span class="text-light price-label position-absolute">
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </span>
                        </div>
                    </div>

                </div>
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                      <span>إجمالي المحصل</span>
                        <span id="total_collected">
                            <span class="text-light price-label position-absolute">
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </span>
                        </div>
                    </div>

                </div>
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                      <span>إجمالي المبالغ</span>
                        <span id="total_amount">
                            <span class="text-light price-label position-absolute">
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </span>
                        </div>
                    </div>

                </div>
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">

                </div>

            </div>


            <div class="row mt-5">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">
                      <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>عدد الرسائل المرسلة</span>
                            <span id="total_messages">
                                <span class="text-light price-label position-absolute">
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </span>
                        </div>
                    </div>
                      <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>المبالغ بعد ارسال الرسالة</span>
                            <span id="total_after_messages">
                                <span class="text-light price-label position-absolute">
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>إجمالي مبالغ الامس</span>

                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $total_yesterday )  }}

                                    </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>المبالغ لكل دقيقة الامس  </span>

                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $total_yesterday_for_secounds )  }}

                                    </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>


                </div>
            </div>

            {{--  --}}

              {{--  --}}

              <div class="row mt-5">
                <div style="row-gap: 50px;" class="col d-flex flex-wrap justify-content-evenly align-items-baseline">

                   <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>إجمالي مبالغ  الامس  في ذات اللحظة </span>

                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $total_yesterday_at_moment )  }}

                                    </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span>إجمالي  المبالغ لكل دقيقة الحالي </span>

                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $total_for_secounds )  }}

                                    </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-center">
                        <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                            <span> الاغلاق المتوقع </span>

                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $expected_close )  }}

                                    </b>
                                <span class="price-label-wrapper d-flex"></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{--  --}}


            <br><br><br>

        </div>
        <div class="col col-lg-6">
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
                            <span>من أصل {{  number_format($archive->amount??0) }}</span>
                            <span class="text-light price-label position-absolute">
                                <b id="total_donations" style="color:#fff !important ;   text-decoration: none ;">
                                      {{  number_format( $total_prices )  }}

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
    {{--  --}}

    <br>
    <br>
 <div class="content-header row">
<br>
        <div style="margin-right: 80px" class="content-header-center  text-center text-md-end col-md-8 col-12 d-md-block ">
            <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">

                <div class="row">

                    <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                        <label style="    float: inline-start;" class="form-label" for="category_id">{{ __('links.category') }}</label>
                        <select name="category_id" id="category_id" class="form-control ajax_select2 extra_field"
                        data-ajax--url="{{ route('categories.select') }}"
                        data-ajax--cache="true"   >
                        </select>
                    </div>
                    <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                        <label style="    float: inline-start;" class="form-label" for="project_id">{{ __('links.project') }}</label>
                        <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field"data-ajax--cache="true"   >
                    </select>
                    </div>
                    <div class="mb-1 col-md-4  @error('project_id') is-invalid @enderror">
                        <label style="    float: inline-start;" class="form-label" for="">{{ __('links.date') }}</label>
                        <select class="form-control " id="filter_date">
                            <option>اختر</option>
                            <option value="1">اليوم</option>
                            <option value="2">اليوم والامس</option>
                            <option value="3">هذا الاسبوع والاسبوع الماضى</option>
                            <option value="4">هذا الشهر</option>
                            <option value="5">هذا العام</option>
                        </select>
                    </div>
                </div>

                    {{-- <a class="btn btn-sm btn-primary me-1 filter_type waves-effect" href="#" onclick="loadStatistics(14)" data-type="1">
                        <span class="active-sorting text-default">{{ __('admin.new') }}</span>
                        <br>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="#"  onclick="loadStatistics(21)" data-type="2">
                        <span class="active-sorting text-default">{{ __('admin.previous') }}</span>
                        <br>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href=""  onclick="loadStatistics(12)" data-type="3">
                        <span class="active-sorting text-default">{{ __('admin.complete') }}</span>
                        <br>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="#" onclick="loadStatistics(18)" data-type="4">
                        <span class="active-sorting text-default">{{ __('admin.classes') }}</span>
                        <br>
                    </a>
                    <a class="btn btn-sm btn-primary me-1 filter_type waves-effect"href="#"  onclick="loadStatistics(19)" data-type="5">
                        <span class="active-sorting text-default">{{ __('admin.mobadra') }}</span>
                        <br>
                    </a> --}}



                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        <br><br>
        <div id = "card2"  class="card" style="background-color: #27b3c2">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>
                            ( 1 - 10 )
                        </p>

                        <span id="data_10">

                        </span>

                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 11 - 20 )</p>
                        <span id="data_20">

                        </span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 21 - 30 )</p>
                        <span id="data_30">

                        </span>
                    </a>
                </div>

                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 31 - 40 )</p>
                        <span id="data_40">

                        </span>
                    </a>
                </div>
                <br>
                <hr>
                <br>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 41 - 50 )</p>
                        <span id="data_50">

                        </span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 51 - 60 )</p>
                        <span id="data_60">

                        </span>
                    </a>
                </div>

                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 61 - 70 )</p>
                        <span id="data_70">

                        </span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 71 - 80 )</p>
                        <span id="data_80">

                        </span>
                    </a>
                </div>
                <br>
                    <hr>
                <br>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 81 - 90 )</p>
                        <span id="data_90">

                        </span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn- me-1 waves-effect" style="background: #3F506F;color:white" >
                        <p>( 91 - 100 )</p>
                        <span id="data_100">

                        </span>
                    </a>
                </div>
            </div>
         </div>

        {{--  --}}

    </div>
    <br>

<input type="hidden" name="type" id="type" value="1">
@stop

@push('scripts')
<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
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
        setInterval(sendRequest, 60 * 1000 * 5);
        function sendRequest(){
            $.ajax({
            //url: "http://snabl.test/api/statistics",
            url: "https://justclick.net.sa/campaign-management/public/api/statistics",
            success:
                function(data){
                    $('#shop_today_total_donations').text(data.data.total_shop_donations ? data.data.total_shop_donations : 0);
                $('#shop_today_max_donations').text(data.data.max_shop_donations ? data.data.max_shop_donations : 0);
                $('#total_donations').text(data.data.total_prices ? numberWithCommas( data.data.total_prices ) : 0);
                $('#donations_percent').text(data.data.total_percent ? data.data.total_percent : 0);
            }
        });
    };
});

$(window).on('load', function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        getProjectCount();
        loadStatistics();
        $(document).on('change', '#category_id', function(){
                loadStatistics();
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
        $(document).on('change', ['#project_id'], function(){
            loadStatistics();
        });
        $(document).on('change', ['#filter_date'], function(){
            loadStatistics();
        });

            // $.ajax({
            //     type:'GET',
            //     url:"{{ route('changeArchive') }}",
            //     data:{main_archive_id:main_archive_id,pure_select:true},
            //     success:function(data){
            //     toastr['success'](null, 'تم الحديث بنجاح', {
            //         closeButton: true,
            //         tapToDismiss: false,
            //         rtl: true
            //         });
            //        location.reload();
            //     }
            // });

    getTotalAfterMessage();
});

        function loadStatistics() {
            var category_id=$("#category_id").val();
            var project_id=$("#project_id").val();
            var filter_date=$("#filter_date").val();
                var categoryUrl = '{{ route("getProjectStatistics") }}';
                var html=`<div class="spinner-border " role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`;
                $('#data_10').html(html);
                $('#data_20').html(html);
                $('#data_30').html(html);
                $('#data_40').html(html);
                $('#data_50').html(html);
                $('#data_60').html(html);
                $('#data_70').html(html);
                $('#data_80').html(html);
                $('#data_90').html(html);
                $('#data_100').html(html);
             $.ajax({
                type:'GET',
                url:categoryUrl,
                data:{
                    category_id:category_id,
                    project_id:project_id,
                    filter_date:filter_date,
                },
                success:function(data){
                    $('#data_10').html(data.data.data_10);
                    $('#data_20').html(data.data.data_20);
                    $('#data_30').html(data.data.data_30);
                    $('#data_40').html(data.data.data_40);
                    $('#data_50').html(data.data.data_50);
                    $('#data_60').html(data.data.data_60);
                    $('#data_70').html(data.data.data_70);
                    $('#data_80').html(data.data.data_80);
                    $('#data_90').html(data.data.data_90);
                    $('#data_100').html(data.data.data_100);
                }
            });
        }

        function getProjectCount() {
                var html=`<div class="spinner-border " role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`;
                $('#total_projects').html(html);
                $('#total_collected').html(html);
                $('#total_amount').html(html);
                $('#total_messages').html(html);
             $.ajax({
                type:'GET',
                data:{},
                url:"{{ route('getProjectCount') }}",
                success:function(data){
                    $('#total_projects').html(`<span class="text-light price-label position-absolute">`+data.data.total_projects+`<span class="price-label-wrapper d-flex"></span></span>`);

                    $('#total_amount').html(`<span class="text-light price-label position-absolute">`+data.data.total_amount+`<span class="price-label-wrapper d-flex"></span></span>`);

                    $('#total_collected').html(`<span class="text-light price-label position-absolute">`+data.data.total_collected+`<span class="price-label-wrapper d-flex"></span></span>`);

                    $('#total_messages').html(`<span class="text-light price-label position-absolute">`+data.data.total_messages+`<span class="price-label-wrapper d-flex"></span></span>`);
                }
            });
        }
        function getTotalAfterMessage() {
                var html=`<div class="spinner-border " role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`;
                $('#total_after_messages').html(html);
             $.ajax({
                type:'GET',
                data:{},
                url:"{{ route('getTotalAfterMessage') }}",
                success:function(data){
                    $('#total_after_messages').html(`<span class="text-light price-label position-absolute">`+data.data+`<span class="price-label-wrapper d-flex"></span></span>`);
                }
            });
        }
    </script>
@endpush

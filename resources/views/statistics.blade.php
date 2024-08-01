<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرئيسية</title>
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('numbers/css/style.css')  }}">
    <style>
        html, body {
              background-color: #3D4E5E;
        }
        .body{
            background-image:url('{{ asset('static.jpg') }}');
            background-repeat: no-repeat;
            /* background-attachment: fixed; */
            background-position: center;
            background-size: 100% 100%;
                height: 100vh;
        }
        .time-area .time-box {
            padding: 5px 15px;
            border: 1px solid #aaa;
            letter-spacing: 2px;
        }
        #t .line {
            margin: 0 15px;
        }
        #time {
            direction: ltr;
        }
        b{
            color: #fff !important ;
            text-decoration: none ;
        }
        .main-label{
            background: #3D4E5E
        }
        .day_value{
                position: absolute;
            top: 83.5%;
            left: 47%;
            color: white;
            font-size: x-large;
            font-weight: bold;
        }
        .arrive_value{
            position: absolute;
            top: 79.5%;
            left: 45%;
            color: white;
            font-size: x-large;
            font-weight: bold;
        }
    </style>

</head>
<body>

    <span class="arrive_value">{{  number_format(round((($total_prices ?? 0)/36),1))  }} </span>
    <span class="day_value">{{  number_format(round((($total_shop_donations ?? 0)/36),1))  }} </span>
    <div class="body"></div>
    <div class="container">

        {{-- <div style="row-gap: 50px;" class="row mt-5">
            <div class="col d-flex justify-content-center align-items-center">
                <img src="{{  asset('numbers/img/logo.png') }}" width="250" alt="">
            </div>
            <div class="col d-flex justify-content-center align-items-center">
                <img src="{{  asset('numbers/img/main-title.png') }}" width="300" alt="">
            </div>

        </div> --}}

        <div class="row mt-5">
            <div class=" col col-lg-5 col-md-4 col d-none d-lg-block">

                <section class="time-area text-center " >

                        {{-- <h2>توقيت مكة المكرمة</h2> --}}
                        <h1 class="time-box text-center d-inline-block fw-500 color-333">
                            <span id="aa" class="d-inline-block bukra-font"></span>
                            <span id="time" class="d-inline-block bukra-font"></span>
                        </h1>
                        <h3 id="t" class="text-center fw-500">
                            {{-- {{ hijri( date('Y-m-d') ) }} --}}
                        </h3>

                </section>
                {{-- <section class="time-area text-center " >

                <table class="table table-bordered" id="result-pages" style="    background: aliceblue;
    font-size: smaller;" >
                        <thead>
                        <tr>
                            <th >الصفحات النشطة</th>
                            <th width="10%">عدد المتواجدين</th>
                        </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>

                </section> --}}

            </div>
            <div class="col col-lg-7" style="position: absolute;top:95%">
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
                        {{-- <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('numbers/img/icons/transfer.png')}}" width="38" alt="">
                            <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                                <span>إجمالي تبرعات</span>
                                <span>اليوم من التحويل</span>
                                <span class="text-light price-label position-absolute">
                                    <b> {{ $total_transfer ?? 0  }} </b>
                                    <span>ر.س</span>
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </div>
                        </div> --}}
                        {{-- <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('numbers/img/icons/cash.png')}} " width="38" alt="">
                            <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                                <span>إجمالي تبرعات</span>
                                <span>الـيـــوم</span>
                                <span class="text-light price-label position-absolute">
                                    <b> {{ $total_donations ?? 0   }}  </b>
                                    <span>ر.س</span>
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </div>
                        </div> --}}
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
                        {{-- <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('numbers/img/icons/calcu.png')}}" width="38" alt="">
                            <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                                <span>أعلى مبلغ تبرع</span>
                                <span>لليوم من التحويل</span>
                                <span class="text-light price-label position-absolute">
                                    <b> {{  $max_transfer  ?? 0 }} </b>
                                    <span>ر.س</span>
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </div>
                        </div> --}}
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

                                        {{  number_format( $total_prices )  }}
                                        </b>
                                    <span>ر.س</span>
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </div>
                        </div>
                        {{-- <div class="d-flex flex-column align-items-center">
                            <img src="{{ asset('numbers/img/icons/users.png')}}" width="54" alt="">
                            <div class="text-light fw-bold d-flex flex-column main-label position-relative">
                                <span> المتواجدون الان بالمتجر</span>
                                <span></span>
                                <span class="text-light price-label position-absolute">
                                    <b id="active-users">  0  </b>
                                    <span class="price-label-wrapper d-flex"></span>
                                </span>
                            </div>
                        </div> --}}
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
            <div class="col col-lg-7">
            </div>
            </div>
        </div>




    </div>


<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/main.js') }}"></script>

    <script>

function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}
    $(document).ready(function(){

        setInterval(sendRequest, 60 * 1000 * 5); // every 5 minitues

        function sendRequest(){
            $.ajax({
            //url: "http://snabl.test/api/statistics",
            url: "https://justclick.net.sa/campaign-management/public/api/statistics",
            success:
                function(data){

                $('#shop_today_total_donations').text(data.data.total_shop_donations ?  data.data.total_shop_donations : 0); //insert text of test.php into your div
                $('#shop_today_max_donations').text(data.data.max_shop_donations ? data.data.max_shop_donations : 0);
                $('#total_donations').text(data.data.total_prices ? numberWithCommas( data.data.total_prices ) : 0);
                $('#donations_percent').text(data.data.total_percent ? data.data.total_percent : 0);

            }

        });

        };

    });

    </script>
<script type="text/javascript">
//   setInterval(function(){
//     call();
//   },5000);

  function call(){

  }
  call();

  function get(action){

  }
  $(document).on('click','.open-link',function(){
    link = $(this).attr('data-link');
    link = '<?php echo DOMAIN;?>'+link;
    window.open(link, '_blank');
  });

</script>
</body>
</html>


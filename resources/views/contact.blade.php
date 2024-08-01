<!doctype html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إدارة تعليم البنين</title>
  <link href="{{ asset('assets/admin/css-rtl/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('site') }}/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container-fluid">
    <div class="row donate-form ">
      <div class="col mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                <div class="card">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input  class=" form-control" name="phone" id="phone" type="number">
                            <button class="btn btn-outline-secondary" id="next" type="button">التالى</button>
                        </div>
                        <div class="row" id="loading" style="display: none">
                            <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/Loading_2.gif') }}">
                            </div>
                        </div>
                        <div class="row" id="donerDetails">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
      </div>
    </div>
  </div>

    <script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/admin') }}/vendors/js/vendors.min.js"></script>

<script>
    $(document).ready(function(){
        var phone=0;
        $("#next").on('click', function() {
           phone=$("#phone").val();
            $("#loading").show();
            sendRequest(phone);
        });

        $("#contactUs").on('click', function() {
console.log('ass')
sendRequestNotes();
});
});

function sendRequest(phone){
    $.ajax({
        url: "{{ route('donerDetails') }}?phone="+phone,
            success:
            function(data){
                console.log(data.message);
                $("#donerDetails").html(data);
                $("#loading").hide();
            }
        });
    }
    function sendRequestNotes(phone){
        console.log('assss')
         phone=$("#doner_id").val();
           doner_id=$("#doner_id").val();
           notes=$("#notes").val();
        $.ajax({
            url: "{{ route('contactUs') }}?phone="+phone+'&doner_id='+doner_id+'&notes='+notes,
            success:
            function(data){

                $("#successMessage").show();
                $("#successMessage").html(data.message);
            }
        });
    }
</script>
</body>

</html>

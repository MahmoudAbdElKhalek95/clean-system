<!doctype html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إدارة تعليم البنين</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('site') }}/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  <style>
    video{
        width: 100%
    }
  </style>
      <script type="text/javascript" src="{{ asset('site') }}/jsPretty/jsqrscanner.nocache.js"></script>
</head>

<body>

  <div class="container-fluid">
    <div class=" row" style="position: absolute;width:100%">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div style="width: 70%;height: 40%;margin: auto">
                <div class="qrscanner" id="scanner"></div>
            </div>
        </div>
        <div class="col-md-4"></div>

    </div>

    <div class="row donate-form ">
      <div class="col mt-5" style="margin-top: 5rem!important">

        <div class="row h-100 mt-5">

          <div class="col d-flex flex-column align-items-center justify-content-center mt-5">
            {{-- <img src="{{ asset('site') }}/icon-donate.svg" width="48" height="48" alt=""> --}}
            <h1 style="color: #fff; font-size: 30px;" class="fw-bold"> وجه الكاميرا الى رمز الاستجابة السريع</h1>
            <div class="position-relative">
              <input id="scannedTextMemo"
                style="background-color: #fff !important; width: 483.86px; height: 72px; border-radius: 20px; font-size: 40px;text-align:center"
                class="form-control borderless" type="text" readonly>
            </div>
          </div>
              <div class="col-md-12 alert alert-success text-center" id="success" style="display: none;"></div>
              <div class="col-md-12 alert alert-danger text-center" id="error" style="display: none;"></div>
              <div class="col-md-12  text-center alert alert-primary" style="    height: 120px;">
                <h3>عدد الحاضرين :   <span id="attendance">{{ $attendance }}</span> </h3>
                <h3>المتبقى :   <span id="not_attendance">{{ $not_attendance }}</span> </h3>
            </div>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">
  function onQRCodeScanned(scannedText) {
    var scannedTextMemo = document.getElementById("scannedTextMemo");
    if (scannedTextMemo) {
        scannedTextMemo.value = scannedText;
        showHint(scannedText);

    }
    // var scannedTextMemoHist = document.getElementById("scannedTextMemoHist");
    // if(scannedTextMemoHist)
    // {
    // 	scannedTextMemoHist.value = scannedTextMemoHist.value + '\n' + scannedText;
    // }
  }
    function play() {
    var audio = new Audio("{{ asset('audio_file.mpeg') }}");
    audio.play();
    }
    function showHint(serial) {

        if (serial.length == 0) {
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                jsondata=JSON.parse(this.responseText);
                    play();
                if(jsondata.status===0){
                    document.getElementById('error').innerHTML=jsondata.message;
                    document.getElementById('error').style.display="block";
                    document.getElementById('success').style.display="none";
                }
                else{
                    document.getElementById('success').innerHTML=jsondata.message;
                    document.getElementById('attendance').innerHTML=jsondata.attendance;
                    document.getElementById('not_attendance').innerHTML=jsondata.not_attendance;
                    document.getElementById('success').style.display="block";
                    document.getElementById('error').style.display="none";

                }
            }
            };
            xmlhttp.open("GET", "{{ route('checkSerial') }}?s=" + serial, true);
            xmlhttp.send();
        }
    }

  function provideVideo() {
    var n = navigator;

    if (n.mediaDevices && n.mediaDevices.getUserMedia) {
      return n.mediaDevices.getUserMedia({
        video: {
          facingMode: "environment"
        },
        audio: false
      });
    }

    return Promise.reject('Your browser does not support getUserMedia');
  }

  function provideVideoQQ() {
    return navigator.mediaDevices.enumerateDevices()
      .then(function (devices) {
        var exCameras = [];
        devices.forEach(function (device) {
          if (device.kind === 'videoinput') {
            exCameras.push(device.deviceId)
          }
        });

        return Promise.resolve(exCameras);
      }).then(function (ids) {
        if (ids.length === 0) {
          return Promise.reject('Could not find a webcam');
        }

        return navigator.mediaDevices.getUserMedia({
          video: {
            'optional': [{
              'sourceId': ids.length === 1 ? ids[0] : ids[1]//this way QQ browser opens the rear camera
            }]
          }
        });
      });
  }

  //this function will be called when JsQRScanner is ready to use
  function JsQRScannerReady() {
    //create a new scanner passing to it a callback function that will be invoked when
    //the scanner succesfully scan a QR code
    var jbScanner = new JsQRScanner(onQRCodeScanned);
    //var jbScanner = new JsQRScanner(onQRCodeScanned, provideVideo);
    //reduce the size of analyzed image to increase performance on mobile devices
    jbScanner.setSnapImageMaxSize(300);
    var scannerParentElement = document.getElementById("scanner");
    if (scannerParentElement) {
      //append the jbScanner to an existing DOM element
      jbScanner.appendTo(scannerParentElement);
    }
  }
</script>
</body>

</html>

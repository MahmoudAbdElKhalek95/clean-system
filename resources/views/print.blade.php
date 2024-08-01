<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة الشهادة</title>
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>
<body onload="window.print()">
    {{--  <img src="{{ asset('certificate2.jpg') }}" alt="">  --}}
    <img src="{{ asset( $file ) }}" alt="">

</body>
</html>

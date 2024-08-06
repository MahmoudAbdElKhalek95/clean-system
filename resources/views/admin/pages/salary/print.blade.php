<!DOCTYPE html>
<html>

<head>

    <link href="https://fonts.googleapis.com/css?family=Libre+Barcode+128" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="//www.fontstatic.com/f=boutros-ads" />
    <style>
        @font-face {
            font-family: 'ae_almateenbold';
            src: url('http://localhost/justclick/skin/fonts/almateen/ae_AlMateen.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'al-mohanad';
            src: url('http://localhost/justclick/skin/fonts/AL-Mohanad-Bold.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
           /* font: 12pt "ae_almateenbold";*/
           font-family: 'Cairo';font-size: 22px;
            font-weight: bold;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .mohanad-font {
            font-family: "al-mohanad";
            font-size: 30px;
        }

        h3 {
            font-family: "al-mohanad";
            font-size: 30px;
        }

        .page {
            width: 210mm;
            height: 297mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);


        }

        h1,
        p {
            font-size: 20px;
            color: #000000;
            text-align: right;
            direction: rtl;

        }

        h2 {
            font-size: 12px;
            color: #000000;
            text-align: right;
            direction: rtl;

        }

        p {
            font-size: 21px;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .subpage {
            padding: 60px 0;
        }

        .subject {

            margin-top: 23px;
            direction: rtl;
            width: 95px;
            text-align: right;
            font-weight: bold;
            font-size: 24px;
            color: #000000;
        }

        .date {
            margin-top: 0px;
            direction: rtl;
            width: 110px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            color: #000000;
        }

        .serial {
            margin-top: 10px;
            direction: rtl;
            width: 105px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            color: #000000;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                font-weight: bold;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        table {
            direction: rtl;
        }

        table td {
            text-align: center;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin: 10px;
        }

        table.border,
        table.border th,
        table.border td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .header{
            background: #d9d9d9;
        }

        .px-6 {
            padding-right: 24px;
            padding-left: 24px;
        }
    </style>
</head>

<body>

    <div class="book">
        <div class="page px-6" style="padding-top: 140px">
            <center>
            <h1>  سند صرف راتب  </h1>

            <table class="border" style="width: 98%;margin-top: 20px">

              
                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px"> التاريخ  </td>
                    <td colspan=""    height="50px" >     {{ date('Y/m/d') }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                 
                    <td colspan=""   height="50px" >     الوقت </td>
                    <td colspan=""   height="50px" >   {{  date('H:i:s'); }}  </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >   رقم السند   </td>
                    <td colspan=""   height="50px" >     {{ $item->id ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >   {{__('workers.national_id')}}   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->national_id ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >  اسم الموظف   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->name ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >  مهنه الموظف   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->job ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >   مكان العمل   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->job_place ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >   اسم المدرسة  </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->school->name ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >    حالة العامل   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->status_name ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >    مبلغ قدره   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->salary ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >     المبلغ بالحروف   </td>
                    <td colspan=""   height="50px" >     {{ $item->worker->getsalaryInArabic() ?? null }}     </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >      اتعهد   </td>
                    <td colspan=""   height="50px" >      اتعهد بانني استلمت المبلغ  الموضح اعلاه   </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >      التوقيع   </td>
                    <td colspan=""   height="50px" >               </td>

                </tr>

                <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >      مشرف المجموعة   </td>
                    <td colspan=""   height="50px" >         علاء عيسى      </td>

                </tr>    <tr height="30px" class="active text-center">
                  
                    <td colspan=""   height="50px" >      التوقيع   </td>
                    <td colspan=""   height="50px" >               </td>

                </tr>


                



             




            </table>

            <br><br>

       

       
       


            </center>
            </div>

    </div>
    <script type="text/javascript">
        var map = [
            "&\#1632;", "&\#1633;", "&\#1634;", "&\#1635;", "&\#1636;",
            "&\#1637;", "&\#1638;", "&\#1639;", "&\#1640;", "&\#1641;"
        ]

        var replaceDigits = function () {


            document.body.innerHTML =
                document.body.innerHTML.replace(
                    /\d(?=[^<>]*(<|$))/g,
                    function ($0) {
                        return map[$0]
                    }
                );
        }

        window.onload = function () {
            replaceDigits();
           // window.print();
        }

    </script>
</body>

</html>

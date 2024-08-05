<?php

require_once((__DIR__ . '/../'.'arabic/Arabic.php'));
require_once((__DIR__ . '/../'.'phpqrcode/qrlib.php'));

use App\Models\Link;
use App\Models\User;
use App\Models\Project;
use App\Models\DonerType;
use App\Models\SendingTemplate;
use Google\Service\Docs\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


function generatePngQrcode($serial)
{
    $tempDir = __DIR__ . '/../public/images/';
    $fileName = $serial.'.png';
    $pngAbsoluteFilePath = $tempDir.$fileName;
    QRcode::png($serial, $pngAbsoluteFilePath, QR_ECLEVEL_L, 10);
    return asset('images/'.$fileName);
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (!function_exists('getDonerType')) {
    function getDonerType($total)
    {
        $type= DonerType::where('from','<=',$total)->where('to','>=',$total)->first();
        return $type->name??'----';
    }
}
if (!function_exists('api_asset')) {
    function api_asset($id)
    {
        return "";
    }
}
if (!function_exists('multi_asset')) {
    function multi_asset($Ids)
    {

        return "";
    }
}
if (!function_exists('getSpaceUrl')) {
    function getSpaceUrl($img)
    {
        return 'https://' . env('DO_SPACES_BUCKET') . '/' . $img;
    }
}
if (!function_exists('randomFromNumbers')) {
    function randomFromNumbers($times, $numbersArr)
    {
        if (count($numbersArr) > 0) {
            $random = [];
            for ($i = 0; $i < $times; $i++) {
                if ($i + 1 > count($numbersArr) && count($numbersArr) > 3) {
                    break;
                }
                $randKey = array_rand($numbersArr);
                $randNumber = $numbersArr[$randKey];
                if (($key = array_search($randNumber, $numbersArr)) !== false) {
                    unset($numbersArr[$key]);
                }
                $random[] = $randNumber;
            }
            return $random;
        }
        return [];
    }
}
if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url)
    {
        $youtube_id = '';
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        $fullEmbedUrl = 'https://www.youtube.com/embed/' . $youtube_id;
        return $fullEmbedUrl;
    }
}
function strip_only($str, $tags, $stripContent = false)
{
    $content = '';
    if (!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if (end($tags) == '') {
            array_pop($tags);
        }
    }
    foreach ($tags as $tag) {
        if ($stripContent) {
            $content = '(.+</' . $tag . '[^>]*>|)';
        }
        $str = preg_replace('#</?' . $tag . '[^>]*>' . $content . '#is', '', $str);
    }
    return $str;
}
function number_category($number)
{
    if ($number <= 10) {
        return 'A';
    } elseif ($number <= 20) {
        return 'B';
    } elseif ($number <= 30) {
        return 'C';
    } elseif ($number <= 40) {
        return 'D';
    } elseif ($number <= 50) {
        return 'E';
    } elseif ($number <= 60) {
        return 'F';
    } elseif ($number <= 70) {
        return 'G';
    } elseif ($number <= 80) {
        return 'H';
    } elseif ($number <= 90) {
        return 'I';
    } elseif ($number <= 100) {
        return 'J';
    } elseif ($number <= 110) {
        return 'K';
    } elseif ($number <= 120) {
        return 'L';
    } elseif ($number <= 130) {
        return 'M';
    } elseif ($number <= 140) {
        return 'N';
    } elseif ($number <= 150) {
        return 'O';
    } elseif ($number <= 160) {
        return 'P';
    } elseif ($number <= 170) {
        return 'Q';
    } elseif ($number <= 180) {
        return 'R';
    } elseif ($number <= 190) {
        return 'S';
    } elseif ($number <= 200) {
        return 'T';
    } elseif ($number <= 210) {
        return 'U';
    } elseif ($number <= 220) {
        return 'V';
    } elseif ($number <= 230) {
        return 'W';
    } elseif ($number <= 240) {
        return 'X';
    } elseif ($number <= 250) {
        return 'Y';
    } elseif ($number <= 260) {
        return 'Z';
    }
    return '';
}
function encryptText($string, $encrypt = true)
{
    $secret_key = 'Cb9eGT2s#~';
    $secret_iv  = '3#t;fV._N[';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($encrypt) {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
if (!function_exists('apiResponse')) {
    function apiResponse($success = false, $data = null, $message = '', $errors = null, $code = 200, $version = 1)
    {
        $response = [
            'version' => $version,
            'success' => $success,
            'status'  => $code,
            'data'    => $data,
            'message' => $message,
            'errors'  => $errors,
        ];
        return response()->json($response, $code);
    }
}
if (!function_exists('welcomeMessage')) {
    function welcomeMessage()
    {
        $time = date("H");
        $timezone = date("e");
        if ($time < "12") {
            return __('admin.good_morning');
        } elseif ($time >= "12" && $time < "17") {
            return __('admin.good_afternoon');
        } else {
            if ($time >= "17" && $time < "19") {
                return __('admin.good_evening');
            } elseif ($time >= "19") {
                return __('admin.good_night');
            }
        }
        return "";
    }
}
if (!function_exists('convertArabicNumbers')) {
    function convertArabicNumbers($string)
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $num = range(0, 9);

        return str_replace($arabic, $num, $string);
    }
}
if (!function_exists('storeFile')) {
    function storeFile($image, $destination)
    {
        $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/' . $destination, $fileName);
        return $fileName;
    }
}
function generateUserUniqueCode(): ?string
{
    $code = mt_rand(1, 1000000);
    if (User::where('code', $code)->exists()) {
        generateUserUniqueCode();
    }
    return $code;
}
function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

define('VIEW', '262395553');
define('SERVICE_ACCOUNT', 'amazing-office-236814-1a8e26d18384.json');
define('DOMAIN', 'https://give.qb.org.sa');

function formate_phone_number($phone)
{

    return "+966".substr($phone, 1, strlen($phone));
}



function arabic_utf8($string)
{
    global $Arabic;
    if($Arabic == null) {
        $Arabic = new I18N_Arabic('Glyphs');
    }
    //   $Arabic = new I18N_Arabic('Glyphs');


    return $Arabic->utf8Glyphs($string, 50, 1);
}


function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}


function wirte_text_image($text)
{
    $height = 1000;
    // if(strlen($text)>129){
    // }else{
    //     $height = 990;
    // }

    $img = Image::make(public_path('compleat.jpg'));
    $img->text($text ?? '', 1300, 1100, function ($font) {
        $font->file(public_path('new/webfonts/helvetica-neue-w23-for-sky-reg.ttf'));
        $font->size(55);
        $font->color('#fff');
        $font->align('right');
        // $font->valign('right');
        $font->angle(0);
    });

    $extension = $img->extension  ;
    $fileName = $img->filename  ;
    $file = rand(1, 99999)."_".$fileName.".".$extension ;
    if (!file_exists('images')) {
        mkdir('public/images', 666, true);
    }
    $img->save('images/'.$file);

    return asset('images/'.$file) ;

}
function wirte_text_image_hour($text)
{
    $height = 1000;
    // if(strlen($text)>129){
    // }else{
    //     $height = 990;
    // }

    $img = Image::make(public_path('hour.jpeg'));
    $img->text($text ?? '', 800, 847, function ($font) {
        $font->file(public_path('new/webfonts/helvetica-neue-w23-for-sky-reg.ttf'));
        $font->size(35);
        $font->color('#fff');
        $font->align('right');
        // $font->valign('right');
        $font->angle(0);
    });

    $extension = $img->extension  ;
    $fileName = $img->filename  ;
    $file = rand(1, 99999)."_".$fileName.".".$extension ;
    if (!file_exists('images')) {
        mkdir('public/images', 666, true);
    }
    $img->save('images/'.$file);

    return asset('images/'.$file) ;

}

function compelte_category_array()
{

    $project = Project::with('category')
        ->leftJoin('links', 'links.project_number', 'projects.code')
        ->groupBy('projects.id')
        ->select([
        'projects.id',
         DB::raw('sum(links.total) as total_done'),
       ])->get();


    $complete_categoryy_arr = [] ;

    foreach($project as $item) {

        $total_done =  $item -> total_done ;

        $find = Project::find($item->id) ;
        $target =  $find->quantityInStock * $find->price ;
        if ($target > 0) {

            $percent = ($total_done / $target) * 100 ;

        } else {

            $percent = 0  ;

        }

        $percent = number_format($percent, 2) ;

        //return $percent ;
        if($percent >= 100) {

            array_push($complete_categoryy_arr, $find->category_id) ;

        }



    }

    return ($complete_categoryy_arr) ;


}




function uncompelte_category_array()
{

    $project = Project::with('category')
        ->leftJoin('links', 'links.project_number', 'projects.code')
        ->groupBy('projects.id')
        ->select([
        'projects.id',
         DB::raw('sum(links.total) as total_done'),
       ])->get();


    $uncomplete_categoryy_arr = [] ;

    foreach($project as $item) {

        $total_done =  $item -> total_done ;

        $find = Project::find($item->id) ;
        $target =  $find->quantityInStock * $find->price ;
        if ($target > 0) {

            $percent = ($total_done / $target) * 100 ;

        } else {

            $percent = 0  ;

        }

        $percent = number_format($percent, 2) ;

        //return $percent ;
        if($percent < 100) {

            array_push($uncomplete_categoryy_arr, $find->category_id) ;

        }



    }

    return ($uncomplete_categoryy_arr) ;


}



function compelte_project_array()
{

    $project = Project::with('category')
        ->leftJoin('links', 'links.project_number', 'projects.code')
        ->groupBy('projects.id')
        ->select([
        'projects.id',
         DB::raw('sum(links.total) as total_done'),
       ])->get();


    $complete_project_arr = [] ;

    foreach($project as $item) {

        $total_done =  $item -> total_done ;

        $find = Project::find($item->id) ;
        $target =  $find->quantityInStock * $find->price ;
        if ($target > 0) {

            $percent = ($total_done / $target) * 100 ;

        } else {

            $percent = 0  ;

        }

        $percent = number_format($percent, 2) ;

        //return $percent ;
        if($percent >= 100) {

            array_push($complete_project_arr, $find->id) ;

        }



    }

    return ($complete_project_arr) ;


}


function uncompelte_project_array($perc)
{

    $project = Project::with('category')
        //->whereNotIn('projects.id' , compelte_project_array() )
        ->leftJoin('links', 'links.project_number', 'projects.code')
        ->groupBy('projects.id')
        ->select([
        'projects.id',
         DB::raw('sum(links.total) as total_done'),
       ])->get();

    $uncomplete_project_arr = [] ;

    foreach($project as $item) {

        $total_done =  $item -> total_done ;

        $find = Project::find($item->id) ;
        $target =  $find->quantityInStock * $find->price ;
        if ($target > 0) {

            $percent = ($total_done / $target) * 100 ;

        } else {

            $percent = 0  ;

        }

        $percent = number_format($percent, 2) ;

        //return $percent ;
        if($percent < 100   &&  $percent == $perc) {

            array_push($uncomplete_project_arr, $item->id) ;

        }


    }

    return ($uncomplete_project_arr) ;


}


function get_statistics($category_id)
{

    $projects_ids =  compelte_project_array() ;
    ;
    $project = Project::with('category')->whereNotIn('id', $projects_ids)
      ->where('category_id', $category_id)
      ->get() ;

    $total_done = 0 ;
    $total_price = 0 ;

    foreach($project as  $item) {

        $total_done += Link::where('project_number', $item->code)->sum('total') ;

        $total_price += $item->price *  $item->quantityInStock  ;
    }

    $data['count'] =   $project ->count() ;
    $data['total_price'] =   $total_price ;
    $data['total_done'] =   $total_done ;


    return $data ;


}



function get_statistics_arr($arr)
{


    $total_done = 0 ;
    $total_price = 0 ;

    foreach($arr as  $item) {

        $total_done += Link::where('project_number', $item->code)->sum('total') ;

        $total_price += $item->price *  $item->quantityInStock  ;
    }

    $data['count'] =   $arr->count() ;
    $data['total_price'] =   $total_price ;
    $data['total_done'] =   $total_done ;


    return $data ;


}


function get_statistics1($category_id)
{


    return    $data = Project::with('category')
         ->leftJoin('links', 'links.project_number', 'projects.code')
          ->groupBy('projects.id')
          ->whereIn('projects.category_id', [10, 12 , 14, 18 , 19 ])
          ->select([
          'projects.id',
          DB::raw('count(*) as count'),
          DB::raw('sum(links.total) as total_done'),
      ])->get() ;


}


function get_statistics_percent($category_id)
{


    $projects_ids =  compelte_project_array() ;
    $data = Project::with('category')  ->whereNotIn('id', $projects_ids)
     ->where('category_id', $category_id)
     ->get() ;


    $filterData_ids = [];
    $filterData_ids1 = [];
    $filterData_ids2 = [];
    $filterData_ids3 = [];
    $filterData_ids4 = [];
    $filterData_ids5 = [];
    $filterData_ids6 = [];
    $filterData_ids7 = [];
    $filterData_ids8 = [];
    $filterData_ids9 = [];
    $filterData_id10 = [];



    foreach($data as $item) {




        if($item->getPercent() >= 1  &&  $item->getPercent() <= 10) {

            array_push($filterData_ids1, $item->id) ;

        }

        // end  1


        if($item->getPercent() >= 11  &&  $item->getPercent() <= 20) {

            array_push($filterData_ids2, $item->id) ;

        }

        // end   2



        if($item->getPercent() >= 21  &&  $item->getPercent() <= 30) {

            array_push($filterData_ids3, $item->id) ;

        }

        // end   3


        if($item->getPercent() >= 31 &&  $item->getPercent() <= 40) {

            array_push($filterData_ids4, $item->id) ;

        }

        // end   4


        if($item->getPercent() >= 41 &&  $item->getPercent() <= 50) {

            array_push($filterData_ids5, $item->id) ;

        }

        // end   5

        if($item->getPercent() >= 51 &&  $item->getPercent() <= 60) {

            array_push($filterData_ids6, $item->id) ;

        }

        // end   6



        if($item->getPercent() >= 61 &&  $item->getPercent() <= 70) {

            array_push($filterData_ids7, $item->id) ;

        }

        // end   7


        if($item->getPercent() >= 71 &&  $item->getPercent() <= 80) {

            array_push($filterData_ids8, $item->id) ;

        }

        // end   8



        if($item->getPercent() >= 81 &&  $item->getPercent() <= 90) {

            array_push($filterData_ids9, $item->id) ;

        }

        // end   9



        if($item->getPercent() >= 91 &&  $item->getPercent() < 100) {

            array_push($filterData_id10, $item->id) ;

        }

        // end   10

    }


    $data_1 = Project::with('category')->whereIn('id', $filterData_ids1)->get() ;
    $data_2 = Project::with('category')->whereIn('id', $filterData_ids2)->get() ;
    $data_3= Project::with('category')->whereIn('id', $filterData_ids3)->get() ;
    $data_4 = Project::with('category')->whereIn('id', $filterData_ids4)->get() ;
    $data_5 = Project::with('category')->whereIn('id', $filterData_ids5)->get() ;
    $data_6 = Project::with('category')->whereIn('id', $filterData_ids6)->get() ;
    $data_7 = Project::with('category')->whereIn('id', $filterData_ids7)->get() ;
    $data_8 = Project::with('category')->whereIn('id', $filterData_ids8)->get() ;
    $data_9 = Project::with('category')->whereIn('id', $filterData_ids9)->get() ;
    $data_10 = Project::with('category')->whereIn('id', $filterData_id10)->get() ;

    $all_data['data_1'] =  get_statistics_arr($data_1) ;
    $all_data['data_2'] =  get_statistics_arr($data_2) ;
    $all_data['data_3'] =  get_statistics_arr($data_3) ;
    $all_data['data_4'] =  get_statistics_arr($data_4) ;
    $all_data['data_4'] =  get_statistics_arr($data_4) ;
    $all_data['data_5'] =  get_statistics_arr($data_5) ;
    $all_data['data_6'] =  get_statistics_arr($data_6) ;
    $all_data['data_7'] =  get_statistics_arr($data_7) ;
    $all_data['data_8'] =  get_statistics_arr($data_8) ;
    $all_data['data_9'] =  get_statistics_arr($data_9) ;
    $all_data['data_10'] =  get_statistics_arr($data_10) ;


    return $all_data ;

    // return    $filterData_ids  ;



}




function send_whatsapp_message( $phone , $message  )
{


   ////  $phone = "+966".$item->phone ;
     $phone = "+201018925998" ;
  //  $message = " helloe mahmoud this test message " ;

 //  $phone = intval(formate_phone_number($phone)) ;


  $url =    "https://api.ultramsg.com/instance17697/messages/chat?token=klzmj5y2hftzk2m0&to=$phone&body=$message&priority=10" ;

 //  $url =  "https://api.ultramsg.com/instance17697/messages/chat?token=klzmj5y2hftzk2m0&to=+$phone&body=$message&priority=10";

    ///////////////////////// smss ///

  $ch = curl_init();
  $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_AUTOREFERER, false);
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $webcontent= curl_exec ($ch);
  $error = curl_error($ch);
  curl_close ($ch);


  return  true  ;


}



function app_time()
{
    $offset = (env("APP_DATE_OFFSET") * 24 * 60 * 60) ?? 0;
    return (time() + $offset);
}


function start_of_week($date=null)
{
    if(!$date) $date = date("Y-m-d",app_time());
    if(date("l",strtotime($date))== "Sunday")
        return $date;
    else{
        $start = new DateTime($date);
        $start->modify('Last Sunday');
        return $start->format("Y-m-d");
    }
}

function end_of_week($date=null)
{
    if(!$date) $date = date("Y-m-d",app_time());
    if(date("l",strtotime($date))== "Thursday")
        return $date;
    else{
        $start = new DateTime($date);
        $start->modify('Next Thursday');
        return $start->format("Y-m-d");
    }
}


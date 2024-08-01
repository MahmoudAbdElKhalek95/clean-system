<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public function whatsTemplate(string $phone, $param1)
    {
        try {

            $apiURL = 'https://imapi.bevatel.com/whatsapp/api/message';
            $headers = [
                'Content-Type'=>'application/json' ,
                'Authorization'=>'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTcxNiwic3BhY2VJZCI6MTM4Mzg5LCJvcmdJZCI6NjIxMTAsInR5cGUiOiJhcGkiLCJpYXQiOjE2ODE2Mjk4OTN9.HD18UVrz9seWYC-SBPb2RcJ23j6YHnKkAjTvEw9YHPg'
            ];
            $body = [
                'phone' => $phone,
                'channelId' => 138772,
                'templateName' => 'temp8',
                "languageCode"=> "ar",
                "text"=>"",
                "parameters"=> [
                     $param1
                ],
            ];

            $response = Http::withHeaders($headers)->post($apiURL, $body);
            $statusCode = $response->status();
            $responseBody = json_decode($response->getBody(), true);
            Log::info($statusCode);
            Log::info($responseBody);
            return $statusCode;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }

    public function send(string $number, string $message, $instance, $token): void
    {
        try {
            //    $url ="https://api.ultramsg.com/instance17697/messages/chat?token=klzmj5y2hftzk2m0&to=$number&body=$message&priority=10" ;
            $url ="https://api.ultramsg.com/".$instance."/messages/chat?token=".$token."&to=$number&body=$message&priority=10" ;
            $ch = curl_init();
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $webcontent= curl_exec($ch);
            $error = curl_error($ch);
            Log::info($error);
            Log::info($webcontent);
            curl_close($ch);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }

    public function sendText(string $number, string $message): void
    {
        try {
            $url ="https://api.ultramsg.com/instance17697/messages/chat?token=klzmj5y2hftzk2m0&to=$number&body=$message&priority=10" ;
            $ch = curl_init();
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $webcontent= curl_exec($ch);
            $error = curl_error($ch);
            Log::info($error);
            Log::info($webcontent);
            curl_close($ch);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }
    public function sendImage(string $number, string $image, $instance=null, $token=null): void
    {
        try {
            // $text = "اغتنم ‫العشر الأواخر‬ بعد إكتمال صندوقكم الوقفي اجعل  لك أنت أجر في تحفيظ القرآن‬ بمبلغ بسيط وعمل عظيم ‏ساهم معنا الآن‏ بـ 100 ريال أو ماتجود به نفسك للتبرع : https://give.qb.org.sa/P/582";
            if(!empty($instance)&&!empty($token)) {
                $url ="https://api.ultramsg.com/".$instance."/messages/image?token=".$token."&to=$number&image=$image&priority=10&caption=";
            } else {
                $url ="https://api.ultramsg.com/instance17697/messages/image?token=klzmj5y2hftzk2m0&to=$number&image=$image&priority=10&caption=" ;
            }

            $ch = curl_init();
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $webcontent= curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            Log::error($webcontent);
            Log::error($error);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }
    public function sendImageText(string $number, string $image, $text, $instance=null, $token=null): void
    {
        try {

            if(!empty($instance)&&!empty($token)) {
                $url ="https://api.ultramsg.com/".$instance."/messages/image?token=".$token."&to=$number&image=$image&priority=10&caption=".$text ;
            } else {
                $url ="https://api.ultramsg.com/instance17697/messages/image?token=klzmj5y2hftzk2m0&to=$number&image=$image&priority=10&caption=".$text ;
            }

            $ch = curl_init();
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $webcontent= curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            Log::error($webcontent);
            Log::error($error);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }

    public function serviceStatus(): bool
    {
        try {
            $response = Http::get(config('project.whatsapp.base_url'));

            return $response->ok();
        } catch (\Exception $e) {
            return false;
        }
    }

     public function sendTemplateMessage(string $number, $link ,$template_name )
    {
        try {


            $url ="https://api.karzoun.app/CloudApi.php?token=EAAERA414EMMBO6E0CbHzkuk5iu00TkMXs6eLTtDPggc7zu9fe7IKOoVM7VZBVuOBaDFPfP74elUzVRIWQWOBVdw6d6EGDAONy5OOQ7TA8qUg8qCALx5ZAJyH7uSKvhdD3ApDngoHUtZCpDQQ7LzRVhRiQsgyJ3DgAhggZBgmVHMZB2T61z0cI5kEAxrGlZCqk4SNoxC4qily3vGp5F&sender_id=247447678442620&phone=".$number."&template=".$template_name."".$link ;

            $ch = curl_init();
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $webcontent= curl_exec($ch);
            $error = curl_error($ch);
            // dd($error);
            curl_close($ch);
            Log::error($webcontent);
            Log::error($error);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }
}

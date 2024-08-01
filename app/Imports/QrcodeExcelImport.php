<?php

namespace App\Imports;

use App\Models\QrcodeMessage;
use App\Models\Target;
use App\Models\WhatsappPhone;
use App\Services\WhatsappService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

use Illuminate\Support\Facades\Storage;



use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class QrcodeExcelImport implements ToCollection
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * @param Collection $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        // try {
        $whats = new WhatsappService();
        $whatsphone = WhatsappPhone::findOrFail($this->data['phone_id']);
        foreach ($rows as $key => $row) {
            $image=generatePngQrcode((string)$row[0]);
                continue;
            // if ($key < 1 || $row[0] == null || $row[0] == ' ') {
            //     continue;
            // }

            if (empty($row[1])) {
                throw new \Exception(strval(__('qrcode_messages.messages.name_required')));
            }
            if (empty($row[0])) {
                throw new \Exception(strval(__('qrcode_messages.messages.serial_number_required')));
            }

            if (empty($row[2])) {
                throw new \Exception(strval(__('qrcode_messages.messages.phone_required')));
            }

            $created = $this->createQrcode($row);
            if (! $created) {
                flash(__('targets.row_faild_at_row').' ====> '.$key + 1)->error();
            } else {

                $message = "السلام عليكم ورحمة الله وبركاته%0aأخينا الغالي🤍/".$row[1]." %0aنذكركم  بموعد☑️ %0aحفل تكريم العاملين بحملة تظلل بالقران ٢ ☂️ %0a حضورك يكمل روعة الحفل%0a الوقت⏱️: ٩:٠٠ مساء %0a المكان📍 %0a منتجع جبور للمناسبات%0a 050 316 7852 %0a https://maps.app.goo.gl/XfuvLyqgAD2vL2iC6?g_st=ic %0a العشاء🍽️ %0a الساعه:١٠:١٥%0a بين يديك الباركود الخاص بحضور الحفل يبرز عند الدخول ✨  %0a عين منك لاتغاب 😍";

                // dd($image);
                // $whats->send("+201159153248", $message, "instance43279", "duxmbuda3u2absjk");
                // $whats->sendImage("+201159153248", $image, "instance43279", "duxmbuda3u2absjk");
                // $whats->sendImageText("+201159153248", "https://qrcg-free-editor.qr-code-generator.com/main/assets/images/websiteQRCode_noFrame.png", "instance43279", "duxmbuda3u2absjk");
                // $whats->sendImageText(formate_phone_number($row[3]), $qrcode, $message,$whatsphone->listen_id, $whatsphone->token_id);
            }

        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     flash($e->getMessage())->error();
        // }
        // dd('ss');
    }


    public function createQrcode($row): bool
    {
        DB::beginTransaction();
        try {
            $Qrcodemessage = QrcodeMessage::create([
                'phone_id' => $this->data['phone_id'],
                'name' => $row[1],
                'serial_number' => $row[0],
                'phone' => $row[2]
            ]);
            if ($Qrcodemessage) {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());
            return false;
        }
        return true;
    }

}

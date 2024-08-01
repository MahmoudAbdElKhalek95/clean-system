<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Doner;
use App\Models\Link;
use App\Models\QrcodeMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function contact()
    {
        return view('contact');
    }
    public function scan()
    {

        $data['attendance'] =QrcodeMessage::where('status', 2)->count();
        $data['not_attendance'] = QrcodeMessage::where('status', '!=', 2)->count();
        return view('scan', $data);
    }

    public function donerDetails(Request $request)
    {
        $phone= $request->phone;

        $data = null;
        if($request->filled('phone')) {
            $item=Doner::with('donerType')->where('phone', $request->phone)->first();
            $data = Link::with('project')->where('phone', $request->phone)->get();

            return view('donerDetails', compact('item','data','phone'));
        }
        $item = null;
        return view('donerDetails', compact('item','phone'));
    }

    public function contactUs(Request $request)
    {
        $data = [
            'phone' => $request->phone,
            'doner_id' => $request->doner_id,
            'notes' => $request->notes,
        ];
        $doner=Doner::where('phone', $request->phone)->first();
        if (!$doner) {
           $doner=Doner::create(['phone' => $request->phone]);
        }
        $item = Contact::create($data);

        return response()->json([
             'status' => 1,
             'message' => 'تم ارسال ملاحظاتك بنجاح',
         ]);

    }
    public function checkSerial(Request $request)
    {

        if($request->filled('s')) {
            $qrcode=QrcodeMessage::where('serial_number', $request->s)->first();
            if($qrcode) {
                if($qrcode->status==2) {
                    return response()->json([
                        'status' => 0,
                        'message'=>"تم الحضور من قبل <br> الاسم:  ".$qrcode->name
                    ]);
                }
                $qrcode->update(['status' => 2]);
                $attendance =QrcodeMessage::where('status', 2)->count();
                $not_attendance = QrcodeMessage::where('status', '!=', 2)->count();
                return response()->json([
                'status' => 1,
                'attendance' => $attendance,
                'not_attendance' => $not_attendance,
                'message'=>" تم الحضور <br> الاسم: ".$qrcode->name
                 ]);
            }
        }
        return response()->json([
            'status' => 0,
            'message' => 'هذا السريال غير مسجل لدينا',
        ]);
    }

    public function attendance(Request $request)
    {
        $data = $request->all();
        Log::info('attendance');
        Log::info($data);
        Log::info('attendance222');
        return response()->json([
            'status' => 0,
            'data'=>$data,
            'message' => 'هذا السريال غير مسجل لدينا',
        ]);
    }

}

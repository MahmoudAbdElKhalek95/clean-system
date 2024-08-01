<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QrcodeExcelImport;
use App\Models\QrcodeMessage;
use App\Models\WhatsappPhone;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class QrcodeController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.qrcode_messages.index', get_defined_vars());
    }

    public function create()
    {

        $whats = new WhatsappService();

        // $message = "الحفل غدا ان شاء الله";
        // $whats->send("+201159153248",$message, "instance43279", "duxmbuda3u2absjk");

        $data=QrcodeMessage::all();
        $whatsphone = WhatsappPhone::findOrFail($data[0]->phone_id);
        foreach($data as $row) {
            // $message = "السلام عليكم ورحمة الله وبركاته%0aأخينا الغالي🤍/".$row->name." %0aنذكركم  بموعد☑️ %0aحفل تكريم العاملين بحملة تظلل بالقران ٢ ☂️ %0a حضورك يكمل روعة الحفل%0a الوقت⏱️: ٩:٠٠ مساء %0a المكان📍 %0a منتجع جبور للمناسبات%0a 050 316 7852 %0a https://maps.app.goo.gl/XfuvLyqgAD2vL2iC6?g_st=ic %0a العشاء🍽️ %0a الساعه:١٠:١٥%0a بين يديك الباركود الخاص بحضور الحفل يبرز عند الدخول ✨  %0a عين منك لاتغاب 😍";
            // $message = "أخي الغالي 🤍/".$row->name."%0aتذكيرٌ بالموعد وأملٌ بالحضور 🌹%0aنسعد بلقياكَ اليوم  🌸%0a الوقت⏱️: ٩:٠٠ مساء%0a المكان📍%0a منتجع جبور للمناسبات%0a 050 316 7852%0a https://maps.app.goo.gl/XfuvLyqgAD2vL2iC6?g_st=ic%0a العشاء🍽️%0a الساعه:١٠:١٥%0a%0aحضورك يُكمل روعة الحفل ☂️";
            // $message = "الحفل غدا ان شاء الله";
            // $whats->send("+201159153248", $message, "instance43279", "duxmbuda3u2absjk");
            // $whats->send("+966".$row->phone, $message, "instance43279", "duxmbuda3u2absjk");
            // $row->update(['status' => 1,'send_at' => date('Y-m-d H:i')]);
            // dd('mustafa');
        }
        flash(__('targets.excel_uploaded'))->success();
        return view('admin.pages.qrcode_messages.index', get_defined_vars());
    }

    public function edit($id)
    {
        $item = QrcodeMessage::findOrFail($id);
        return view('admin.pages.qrcode_messages.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = QrcodeMessage::findOrFail($id);
        return view('admin.pages.qrcode_messages.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = QrcodeMessage::findOrFail($id);
        if ($item->delete()) {
            flash(__('qrcode_messages.messages.deleted'))->success();
        }
        return redirect()->route('qrcode_messages.index');
    }

       protected function import(Request $request)
       {
           try {
               $data = [
                   'phone_id'=>$request->phone_id
               ];
               $object = new QrcodeExcelImport($data);

               Excel::import($object, request()->file('file'));
               flash(__('targets.excel_uploaded'))->success();
               return back();
           } catch (\Exception $e) {
               DB::rollback();
               flash($e->getMessage())->error();
           }
       }

    public function list(Request $request)
    {

        $data = QrcodeMessage::with('phoneSetting')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($item) {
                return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                '.__('qrcode_messages.statuses.'.$item->status).'
                        </button>';
            })
            ->addColumn('used_phone', function ($item) {
                return $item->phoneSetting->name??'';
            })
            ->rawColumns(['status','used_phone'])
            ->make(true);
    }

    public function select(Request $request)
    {
        $data = QrcodeMessage::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'name AS text')
             ->get();
        return response()->json($data);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\WhatsappPhone;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class ReminderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.reminders.index', get_defined_vars());
    }

    public function create()
    {
                $phones = WhatsappPhone::all();

        return view('admin.pages.reminders.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $phones = WhatsappPhone::all();

        $item = Reminder::findOrFail($id);
        return view('admin.pages.reminders.edit', get_defined_vars());
    }

    public function show($id)
    {

        $item = Reminder::findOrFail($id);
        return view('admin.pages.reminders.show', get_defined_vars());
    }

    public function destroy($id)
    {

        $item = Reminder::findOrFail($id);
        if ($item->delete()) {
            flash(__('reminders.messages.deleted'))->success();
        }
        return redirect()->route('reminders.index');
    }

    public function store(Request $request)
    {
        try{
            $i = 0;
            foreach($request->day_number as $day_number){
                $item =  new Reminder();
                $item->category_id = $request->category_id;
                $item->day_number = $request->day_number[$i];
                $item->phone_id = $request->phone_id[$i];
                $item->message = $request->message[$i];
                $i++;
                $item->save();
            }
            // if ($this->processForm($request)) {
                flash(__('reminders.messages.created'))->success();
            // }
        } catch (Exception $e) {
            flash(__('reminders.messages.error_save'))->error();
        }
        return redirect()->route('reminders.index');
    }

    public function update(Request $request, $id)
    {

        Reminder::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('reminders.messages.updated'))->success();
        }
        return redirect()->route('reminders.index');
    }

    protected function processForm($request, $id = null)
    {

        $item = $id == null ? new Reminder() : Reminder::findOrFail($id);
         $data= $request->except(['_token', '_method', 'password']);
        $reminder = Reminder::where('category_id', $request->category_id)->first();
        $item = $item->fill($data);
        // if($reminder){
        //     $reminder->update(['message'=>$request->message,'day_number'=>$request->day_number,'phone_id'=>$request->phone_id]);
        //     return $reminder;
        // }else{
           if ($item->save()) {
                return $item;
            }
        // }
        return null;
    }

    public function list(Request $request)
    {

        $data = Reminder::with('category')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category->name ?? '';
            })
              ->editColumn('phone', function ($item) {
                return $item->phone ? $item->phone->name : '';
            })
            ->rawColumns(['category','phone'])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Reminder::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                }
            })
            ->select('id', 'name AS text')
            ->get();
        return response()->json($data);
    }

    public function whatsapp(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $data = Reminder::with('category')->where('category_id', $request->category_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($item) {
                    return $item->category->name ?? '';
                })

                ->rawColumns(['category'])
                ->make(true);
        }
        $item = Reminder::findOrFail($id);
        return view('admin.pages.reminders.whatssapp', get_defined_vars());
    }
    public function savewhatsapp(Request $request)
    {
        return back();
    }


}

?>

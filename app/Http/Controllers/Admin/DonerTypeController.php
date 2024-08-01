<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonerTypeRequest;
use App\Models\DonerType;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;

class DonerTypeController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.doner_types.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.doner_types.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = DonerType::findOrFail($id);
        return view('admin.pages.doner_types.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = DonerType::findOrFail($id);
        return view('admin.pages.doner_types.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = DonerType::findOrFail($id);
        if ($item->delete()) {
            flash(__('doner_types.messages.deleted'))->success();
        }
        return redirect()->route('doner_types.index');
    }

    public function store(DonerTypeRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('doner_types.messages.created'))->success();
        }
        return redirect()->route('doner_types.index');
    }

    public function update(DonerTypeRequest $request, $id)
    {
        $this->userpermission();
        DonerType::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('doner_types.messages.updated'))->success();
        }
        return redirect()->route('doner_types.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new DonerType() : DonerType::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);



        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = DonerType::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = DonerType::distinct()
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
            $data = WhatsappSetting::with('DonerType')->where('DonerType_id', $request->DonerType_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DonerType', function ($item) {
                    return $item->DonerType->name ?? '';
                })
           
                ->rawColumns(['DonerType' , 'type_name' ])
                ->make(true);
        }
        $item = DonerType::findOrFail($id);
        return view('admin.pages.doner_types.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats = WhatsappSetting::where('DonerType_id', $request->DonerType_id)->first();
        $item = $whats == null ? new WhatsappSetting() : $whats;
        $data = $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);
        $item->status = 0;
        if ($item->save()) {
            flash(__('users.messages.updated'))->success();
        }
        return back();
    }


}

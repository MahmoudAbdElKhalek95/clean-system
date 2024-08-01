<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\WhatsappPhone;
use App\Traits\UserPermission;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\WhatsappPhoneRequest;

class WhatsappPhoneController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.whatsapp_phones.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.whatsapp_phones.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = WhatsappPhone::findOrFail($id);
        return view('admin.pages.whatsapp_phones.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = WhatsappPhone::findOrFail($id);
        return view('admin.pages.whatsapp_phones.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = WhatsappPhone::findOrFail($id);
        if ($item->delete()) {
            flash(__('admin.deleted'))->success();
        }
        return redirect()->route('whatsapp_phones.index');
    }

    public function store(WhatsappPhoneRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('admin.created'))->success();
        }
        return redirect()->route('whatsapp_phones.index');
    }

    public function update(WhatsappPhoneRequest $request, $id)
    {
        $this->userpermission();
        WhatsappPhone::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('admin.updated'))->success();
        }
        return redirect()->route('whatsapp_phones.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new WhatsappPhone() : WhatsappPhone::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = WhatsappPhone::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = WhatsappPhone::distinct()
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

?>

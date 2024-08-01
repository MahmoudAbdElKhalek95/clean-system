<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Models\Type;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;

class TypeController extends Controller  /// الفئات 
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.type.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.type.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Type::findOrFail($id);
        return view('admin.pages.type.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Type::findOrFail($id);
        return view('admin.pages.type.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Type::findOrFail($id);
        if ($item->delete()) {
            flash(__('type.messages.deleted'))->success();
        }
        return redirect()->route('type.index');
    }

    public function store(TypeRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('type.messages.created'))->success();
        }
        return redirect()->route('type.index');
    }

    public function update(TypeRequest $request, $id)
    {
        $this->userpermission();
        Type::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('type.messages.updated'))->success();
        }
        return redirect()->route('type.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Type() : Type::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);
        $item->type = 2 ; // // 2  الفئات -

        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Type::where('type' , 2 )->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = Type::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->where('type' , 2)
             ->select('id', 'name AS text')
             ->get();
        return response()->json($data);
    }

  
  

}

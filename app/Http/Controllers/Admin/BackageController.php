<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackageRequest;
use App\Models\Backage;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class BackageController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.backage.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.backage.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Backage::findOrFail($id);
        return view('admin.pages.backage.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Backage::findOrFail($id);
        return view('admin.pages.backage.show', get_defined_vars());
    }

    public function print($id)
    {
      //  $expense =  Backage::findOrFail($id);
        $item = Backage::findOrFail($id);
        return view('admin.pages.backage.print', get_defined_vars());
    }


    public function destroy($id)
    {
        $this->userpermission();
        $item = Backage::findOrFail($id);
        if ($item->delete()) {
            flash(__('backage.messages.deleted'))->success();
        }
        return redirect()->route('backage.index');
    }

    public function store(BackageRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('backage.messages.created'))->success();
        }
        return redirect()->route('backage.index');
    }

    public function update(BackageRequest $request, $id)
    {
        $this->userpermission();
        Backage::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('backage.messages.updated'))->success();
        }
        return redirect()->route('backage.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Backage() : Backage::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $data = Backage::with('subject')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('subject', function ($item) {
                return $item->subject ? $item->subject->name : '';
            })
            ->rawColumns([ 'subject' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Backage::distinct()
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

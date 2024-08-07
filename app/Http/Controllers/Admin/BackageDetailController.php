<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackageDetailRequest;
use App\Models\BackageDetail;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class BackageDetailController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.backage_details.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.backage_details.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = BackageDetail::findOrFail($id);
        return view('admin.pages.backage_details.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = BackageDetail::findOrFail($id);
        return view('admin.pages.backage_details.show', get_defined_vars());
    }

    public function print($id)
    {
      //  $expense =  BackageDetail::findOrFail($id);
        $item = BackageDetail::findOrFail($id);
        return view('admin.pages.backage_details.print', get_defined_vars());
    }


    public function destroy($id)
    {
        $this->userpermission();
        $item = BackageDetail::findOrFail($id);
        if ($item->delete()) {
            flash(__('backage_details.messages.deleted'))->success();
        }
        return redirect()->route('backage_details.index');
    }

    public function store(BackageDetailRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('backage_details.messages.created'))->success();
        }
        return redirect()->route('backage_details.index');
    }

    public function update(BackageDetailRequest $request, $id)
    {
        $this->userpermission();
        BackageDetail::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('backage_details.messages.updated'))->success();
        }
        return redirect()->route('backage_details.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new BackageDetail() : BackageDetail::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $data = BackageDetail::with(['backage'  , 'school'])->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('backage', function ($item) {
                return $item->backage ? $item->backage->name : '';
            })
            ->AddColumn('school', function ($item) {
                return $item->school ? $item->school->name : '';
            })
            ->rawColumns([ 'school' , 'backage' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = BackageDetail::distinct()
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

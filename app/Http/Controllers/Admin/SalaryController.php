<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Models\Salary;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class SalaryController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.salary.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.salary.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Salary::findOrFail($id);
        return view('admin.pages.salary.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Salary::findOrFail($id);
        return view('admin.pages.salary.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Salary::findOrFail($id);
        if ($item->delete()) {
            flash(__('salary.messages.deleted'))->success();
        }
        return redirect()->route('salary.index');
    }

    public function store(SalaryRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('salary.messages.created'))->success();
        }
        return redirect()->route('salary.index');
    }

    public function update(SalaryRequest $request, $id)
    {
        $this->userpermission();
        Salary::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('salary.messages.updated'))->success();
        }
        return redirect()->route('salary.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Salary() : Salary::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Salary::with('worker')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('worker', function ($item) {
                return $item->worker ? $item->worker->name : '';
            })
            ->rawColumns([ 'worker' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Salary::distinct()
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

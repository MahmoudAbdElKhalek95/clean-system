<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerRequest;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Models\Worker;

class WorkerController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.workers.index', get_defined_vars());
    }

    public function create()
    {
       // return "asad" ;
        $this->userpermission();
        return view('admin.pages.workers.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Worker::findOrFail($id);
        return view('admin.pages.workers.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Worker::findOrFail($id);
        return view('admin.pages.workers.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Worker::findOrFail($id);
        if ($item->delete()) {
            flash(__('workers.messages.deleted'))->success();
        }
        return redirect()->route('workers.index');
    }

    public function store(WorkerRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('workers.messages.created'))->success();
        }
        return redirect()->route('workers.index');
    }

    public function update(WorkerRequest $request, $id)
    {
        $this->userpermission();
        Worker::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('workers.messages.updated'))->success();
        }
        return redirect()->route('workers.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Worker() : Worker::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $data = Worker::with(['school' , 'project'] )->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('school', function ($item) {
                return $item->school ? $item->school->name : '';
            })
            ->AddColumn('project', function ($item) {
                return $item->project ? $item->project->name : '';
            })
            ->rawColumns([ 'school', 'project' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Worker::distinct()
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

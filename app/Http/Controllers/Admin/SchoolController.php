<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
class SchoolController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.schools.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.schools.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = School::findOrFail($id);
        return view('admin.pages.schools.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = School::findOrFail($id);
        return view('admin.pages.schools.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = School::findOrFail($id);
        if ($item->delete()) {
            flash(__('schools.messages.deleted'))->success();
        }
        return redirect()->route('school.index');
    }

    public function store(SchoolRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('schools.messages.created'))->success();
        }
        return redirect()->route('school.index');
    }

    public function update(SchoolRequest $request, $id)
    {
        $this->userpermission();
        School::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('schools.messages.updated'))->success();
        }
        return redirect()->route('school.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new School() : School::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = School::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
           // ->rawColumns()
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = School::distinct()
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
            $data = WhatsappSetting::with('School')->where('School_id', $request->School_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('School', function ($item) {
                    return $item->School->name ?? '';
                })

                ->rawColumns(['School'])
                ->make(true);
        }
        $item = School::findOrFail($id);
        return view('admin.pages.schools.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats=WhatsappSetting::where('School_id',$request->School_id)->first();
        $item = $whats == null ? new WhatsappSetting() : $whats;
        $data= $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);
        $item->status = 0;
        if ($item->save()) {
            flash(__('users.messages.updated'))->success();
        }
        return back();
    }


}

?>

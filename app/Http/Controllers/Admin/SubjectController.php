<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class SubjectController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.subject.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.subject.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Subject::findOrFail($id);
        return view('admin.pages.subject.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Subject::findOrFail($id);
        return view('admin.pages.subject.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Subject::findOrFail($id);
        if ($item->delete()) {
            flash(__('subject.messages.deleted'))->success();
        }
        return redirect()->route('subject.index');
    }

    public function store(SubjectRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('subject.messages.created'))->success();
        }
        return redirect()->route('subject.index');
    }

    public function update(SubjectRequest $request, $id)
    {
        $this->userpermission();
        Subject::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('subject.messages.updated'))->success();
        }
        return redirect()->route('subject.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new subject() : Subject::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Subject::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
           // ->rawColumns()
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Subject::distinct()
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
            $data = WhatsappSetting::with('subject')->where('subject_id', $request->subject_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('subject', function ($item) {
                    return $item->subject->name ?? '';
                })

                ->rawColumns(['subject'])
                ->make(true);
        }
        $item = Subject::findOrFail($id);
        return view('admin.pages.subject.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats=WhatsappSetting::where('subject_id',$request->subject_id)->first();
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

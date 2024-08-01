<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArchiveRequest;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.archives.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.archives.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = Archive::findOrFail($id);
        return view('admin.pages.archives.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Archive::findOrFail($id);
        return view('admin.pages.archives.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = Archive::findOrFail($id);
        if ($item->delete()) {
            flash(__('archives.messages.deleted'))->success();
        }
        return redirect()->route('archives.index');
    }

    public function store(ArchiveRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('archives.messages.created'))->success();
        }
        return redirect()->route('archives.index');
    }

    public function update(ArchiveRequest $request, $id)
    {
        Archive::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('archives.messages.updated'))->success();
        }
        return redirect()->route('archives.index');
    }


    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Archive() : Archive::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if ($item->save()) {
            return $item;
        }
        if ($item->save()) {
            return $item;
        }
        return null;
    }
    protected function active(Request $request)
    {
        Archive::where('id','!=',$request->archive_id)->update(['status'=> 0]);
        $item =  Archive::findOrFail($request->archive_id);
        $item->status=1;
        $item->save();

    }


    public function list(Request $request)
    {

        $data = Archive::select('*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($item) {
                if($item->status==1){
                    return '<a class="btn btn-sm btn-outline-primary me-1 waves-effect " href="#">
                    '.__('target_types.statuses.'.$item->status).'
                    </a>';
                }
                return '<a class="btn btn-sm btn-outline-danger me-1 waves-effect checkactive" data-id="'.$item->id.'" href="#">
                '.__('target_types.statuses.'.$item->status).'
                </a>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }


    public function select(Request $request)
    {

        $data = Archive::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'name AS text')
             ->get()->toArray();
             $all=new \stdClass();
             $all->id = 0;
             $all->text = "جميع الحملات";
        array_unshift($data,$all);
        return response()->json($data);
    }
    public function changeArchive(Request $request)
    {
        if($request->main_archive_id==0){
            session()->put('activeArchive', 0);
            session()->put('activeArchiveName', 'جميع الحملات');
            return response()->json([]);
        }else{

            $data = Archive::findOrFail($request->main_archive_id);
            session()->put('activeArchive', $data->id);
            session()->put('activeArchiveName', $data->name);
        }
        return response()->json($data);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InitiativeRequest;
use App\Models\Initiative;
use App\Models\Link;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InitiativeController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.initiatives.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.initiatives.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = Initiative::findOrFail($id);
        return view('admin.pages.initiatives.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Initiative::findOrFail($id);
        return view('admin.pages.initiatives.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = Initiative::findOrFail($id);
        if ($item->delete()) {
            flash(__('initiatives.messages.deleted'))->success();
        }
        return redirect()->route('initiatives.index');
    }

    public function store(InitiativeRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('initiatives.messages.created'))->success();
        }
        return redirect()->route('initiatives.index');
    }

    public function update(InitiativeRequest $request, $id)
    {
        Initiative::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('initiatives.messages.updated'))->success();
        }
        return redirect()->route('initiatives.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Initiative() : Initiative::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if($request->filled('show_in_statistics')){
            $item->show_in_statistics = 1;
        }else{
            $item->show_in_statistics = 0;
        }
        if ($item->save()) {
            $item->users()->detach();
            $item->users()->attach($request->user_id);
             return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Initiative::with(['category','project'])->where(function ($search) use ($request) {
            // if($request->filled('path')){
            //     $search->where('paths.name','like','%',$request->path.'%');
            // }
        })
        ->with(['users' => function ($query) {
                $query->select(DB::raw("CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.mid_name,''),' ',COALESCE(users.last_name,'')) AS full_name"));
        }])
        ->groupBy('initiatives.id')->select('initiatives.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('users', function ($item) {

                return '';
            })
               ->editColumn('type', function ($item) {
                return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('initiatives.model_types.' . $item->type) . '</button>';
            })
            ->addColumn('path', function ($item) {
               return $item->path->name??'';
            })
            ->addColumn('amount', function ($item) {
                if($item->type==1)
                {
                    return Link::where('section_code',$item->code)->count();
                }
                if($item->type==2)
                {
                    $project_codes=Project::where('category_id',$item->category_id)->pluck('code');
                    return Link::whereIn('project_number', $project_codes)->orWhere('category_id', $item->category_id)->count();
                }
                if($item->type==3)
                {
                    if($item->project){
                        return Link::where('project_number',$item->project_id)->count();
                    }
                }
               return 0;
            })
            ->editColumn('code', function ($item) {
                if ($item->type == 1) {
                    return $item->code;
                }
                if ($item->type == 2) {
                    return $item->category ? $item->category->name : '';
                }
                if ($item->type == 3) {
                    return $item->project ? $item->project->name : '';
                }
            })
            ->addColumn('total', function ($item) {

                if($item->type==1)
                {
                    return Link::where('section_code',$item->code)->sum('total');
                }
                if($item->type==2)
                {
                    $project_codes=Project::where('category_id',$item->category_id)->pluck('code');
                    return Link::whereIn('project_number', $project_codes)->sum('total');
                }
                if($item->type==3)
                {
                    if($item->project){
                        return Link::where('project_number',$item->project->code)->sum('total');
                    }
                }
               return 0;
            })
            ->rawColumns(['users','path','amount','total','type'])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Initiative::distinct()
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

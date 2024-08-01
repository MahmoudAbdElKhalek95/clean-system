<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PathRequest;
use App\Models\Link;
use App\Models\Path;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PathController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.paths.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.paths.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = Path::findOrFail($id);
        return view('admin.pages.paths.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Path::findOrFail($id);
        return view('admin.pages.paths.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = Path::findOrFail($id);
        if ($item->delete()) {
            flash(__('paths.messages.deleted'))->success();
        }
        return redirect()->route('paths.index');
    }

    public function store(PathRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('paths.messages.created'))->success();
        }
        return redirect()->route('paths.index');
    }

    public function update(PathRequest $request, $id)
    {
        Path::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('paths.messages.updated'))->success();
        }
        return redirect()->route('paths.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Path() : Path::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if ($item->save()) {
            $item->users()->detach();
            $item->users()->attach($request->user_id);
             return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Path::with(['initiatives','users' => function ($query) {
                $query->select(DB::raw("CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.mid_name,''),' ',COALESCE(users.last_name,'')) AS full_name"));
        }])
         ->select(['paths.*']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('users', function ($item) {
                return '';
            })
            ->addColumn('amount', function ($item) {
                $amount = 0;
                foreach($item->initiatives as $initiative )
                    {
                        if($initiative->type==1)
                        {
                            $amount +=Link::where('section_code',$initiative->code)
                                ->count();
                        }
                        if($initiative->type==2)
                        {
                            $project_codes=Project::where('category_id',$initiative->category_id)->pluck('code');
                          $amount +=Link::whereIn('project_number', $project_codes)->orWhere('category_id', $initiative->category_id)->count();
                        }
                        if($initiative->type==3)
                        {
                            if($initiative->project){
                                $amount +=Link::where('project_number',$initiative->project_id)
                                    ->count();
                            }
                        }

                    }
               return $amount;
            })
            ->addColumn('total', function ($item) {

                $total = 0;
                foreach($item->initiatives as $initiative )
                {
                    if($initiative->type==1)
                    {
                        $total=Link::where('section_code',$initiative->code)
                        ->sum('total');
                    }
                    if($initiative->type==2)
                    {
                        $project_codes=Project::where('category_id',$initiative->category_id)->pluck('code');
                        $total +=Link::whereIn('project_number', $project_codes)->orWhere('category_id', $initiative->category_id)->sum('total');
                    }
                    if($initiative->type==3)
                    {
                            if($initiative->project){
                                $total +=Link::where('project_number',$initiative->project_id)
                                    ->sum('total');
                            }
                        }

                    }
               return $total;
            })
            ->rawColumns(['users','amount','total'])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Path::distinct()
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

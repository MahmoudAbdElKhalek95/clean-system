<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\TargetRequest;
use App\Imports\TargetExcelImport;
use App\Models\Category;
use App\Models\Initiative;
use App\Models\Link;
use App\Models\Path;
use App\Models\Project;
use App\Models\Section;
use App\Models\Target;
use App\Models\User;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TargetController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name AS text')
            ->get();
        $paths = Path::select('id', 'name AS text')
            ->get();
        $users = User::where('type',User::TYPE_CLIENT)->select('id', DB::raw("CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.mid_name,''),' ',COALESCE(users.last_name,'')) AS text"))
            ->get();
        $projects = Project::select('id', 'name AS text')
            ->get();
        $initiatives = Initiative::select('id', 'name AS text')
            ->get();
        return view('admin.pages.targets.index', get_defined_vars());
    }

    public function targets(Request $request)
    {
        return view('admin.pages.targets.all_targets', get_defined_vars());
    }

    public function create()
    {
        $section = null;
        $categories = Category::select('id', 'name AS text')
            ->get();
        $paths = Path::select('id', 'name AS text')
            ->get();
        $users = User::where('type',User::TYPE_CLIENT)->select('id', DB::raw("CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.mid_name,''),' ',COALESCE(users.last_name,'')) AS text"))
            ->get();
        $projects = Project::select('id', 'name AS text')
            ->get();
        $initiatives = Initiative::select('id', 'name AS text')
            ->get();
        return view('admin.pages.targets.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
      $categories = Category::select('id', 'name AS text')
            ->get();
        $paths = Path::select('id', 'name AS text')
            ->get();
        $users = User::where('type',User::TYPE_CLIENT)->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(mid_name,''),' ',COALESCE(last_name,'')) AS text"))
            ->get();
        $projects = Project::select('id', 'name AS text')
            ->get();
        $initiatives = Initiative::select('id', 'name AS text')
            ->get();
        $item = Target::findOrFail($id);
        return view('admin.pages.targets.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        return view('admin.pages.targets.index', get_defined_vars());

    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Target::findOrFail($id);
        if ($item->delete()) {
            flash(__('targets.messages.deleted'))->success();
        }
        return redirect()->route('targets.index');
    }

    public function store(TargetRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('targets.messages.created'))->success();
        }
        return redirect()->route('targets.index');
    }

    public function update(TargetRequest $request, $id)
    {
        $this->userpermission();
        Target::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('targets.messages.updated'))->success();
        }
        return redirect()->route('targets.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Target() : Target::find($id);
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
    protected function import(Request $request)
    {
        try{
            $data = [
                'section_id'=>$request->section_id,
                'type'=>$request->type,
                'user_id'=>$request->user_id
            ];
            $object = new TargetExcelImport($data);
            Excel::import($object, request()->file('file'));
            flash(__('targets.excel_uploaded'))->success();
            return back();
         } catch (\Exception $e) {
            DB::rollback();
            flash($e->getMessage())->error();
        }
    }

    public function list(Request $request)
    {

            $data = Target::orderBy('id','DESC')->select('*');
            // DB::raw('sum(links.price * links.amount) as total')
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('section', function ($item) {
                if ($item->type == 1) {
                    return $item->initiative ? $item->initiative->name : '';
                }
                if ($item->type == 2) {
                    return $item->path ? $item->path->name : '';
                }
                if ($item->type == 3) {
                    return $item->user ? $item->user->name : '';
                }
                if ($item->type == 4) {
                    return $item->targetproject ? $item->targetproject->name : '';
                }
                if ($item->type == 5) {
                    return $item->category ? $item->category->name : '';
                }
            })
            ->editColumn('type', function ($item) {
                return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('targets.model_types.' . $item->type) . '</button>';
            })
             ->editColumn('achieved', function ($item) {
                if($item->type==1){
                    if($item->initiative )
                    {
                        return Link::where(function($query) use ($item){
                            if($item->date_type==1){
                                $query->whereDate('date',$item->day);
                            }else{
                                $query->whereBetween('date',[$item->date_from,$item->date_to]);
                            }
                        })
                        ->where('section_code', $item->initiative->code)
                        ->sum(DB::raw('total'));
                    }
                }elseif($item->type==2){
                    $section_code= Initiative::where('path_id', $item->section_id)->pluck('code')->toArray();
                    return Link::where(function($query) use ($item){
                        if($item->date_type==1){
                            $query->whereDate('date',$item->date);
                        }else{
                            $query->whereBetween('date',[$item->date_from,$item->date_to]);
                        }
                    })
                    ->whereIn('section_code',$section_code)
                    ->sum(DB::raw('total'));
                }elseif($item->type==3){
                    return Link::where(function($query) use ($item){
                        if($item->date_type==1){

                            $query->whereDate('date',$item->day);
                        }else{
                            $query->whereBetween('date',[$item->date_from,$item->date_to]);
                        }
                    })
                    ->where('user_id',$item->section_id)
                    ->sum(DB::raw('total'));

                }elseif($item->type==4){
                    if($item->project){
                        return Link::where(function($query) use ($item){
                            if($item->date_type==1){
                                $query->where('date',$item->date);
                            }else{
                                $query->whereBetween('date',[$item->date_from,$item->date_to]);
                            }
                        })
                        ->where('project_number',$item->project->code)
                        ->sum(DB::raw('total'));
                    }
                }elseif($item->type==5){
                    if($item->category){
                        return Link::where(function($query) use ($item){
                            if($item->date_type==1){

                                $query->where('date',$item->day);
                            }else{
                                $query->whereBetween('date',[$item->date_from,$item->date_to]);
                            }
                        })
                        ->where('category_id',$item->category->category_number)
                        ->sum(DB::raw('total'));
                    }
                }

            })

            ->rawColumns(['section','target','project','achieved','type','date_from','date_to'])
            ->make(true);

          ///  return    $data  ;
    }


    public function alllist(Request $request)
    {
        $today = date('Y-m-d') ;
            $data = Target::whereDate('day' , '<=' , $today )
            ->where('type',$request->type)
            ->groupBy('section_id')
            ->select([
            'section_id',
            DB::raw('sum(target) as all_targets')
            ]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('section', function ($item) use ($request)  {
                if ($request->type == 1) {
                    return $item->initiative ? $item->initiative->name : '';
                }
                if ($request->type == 2) {
                    return $item->path ? $item->path->name : '';
                }
                if ($request->type == 3) {
                    return $item->user ? $item->user->name : '';
                }
                if ($request->type == 4) {
                    return $item->targetproject ? $item->targetproject->name : '';
                }
                if ($request->type == 5) {
                    return $item->category ? $item->category->name : '';
                }
                return $item->initiative ? $item->initiative->name : '';

            })
            ->addColumn('type', function ()use($request) {
                return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('targets.model_types.'.$request->type) . '</button>';
            })
            ->editColumn('achieved', function ($item) use ($today,$request) {
                if($request->type==1){
                    if($item->initiative )
                    {
                        if($item->initiative->type==1)
                        {
                            return Link::where('section_code',$item->initiative->code)
                                ->sum('total');
                        }
                        if($item->initiative->type==2)
                        {
                            $project_codes=Project::where('category_id',$item->initiative->category_id)->pluck('code');
                            return Link::whereIn('project_number', $project_codes)->orWhere('category_id', $item->initiative->category_id)->sum('total');
                        }
                        if($item->initiative->type==3)
                        {
                            if($item->initiative->project){
                                return Link::where('project_number',$item->initiative->project_id)
                                    ->sum('total');
                            }
                        }
                        return Link::where('section_code', $item->initiative->code)
                        ->sum(DB::raw('total'));
                    }
                }elseif($request->type==2){
                    $section_code= Initiative::where('path_id', $item->section_id)->pluck('code')->toArray();
                    return Link::whereIn('section_code',$section_code)
                    ->sum(DB::raw('total'));
                }elseif($request->type==3){
                    return Link::where('user_id',$item->section_id)
                    ->sum(DB::raw('total'));

                }elseif($request->type==4){
                    if($item->project){
                        return Link::where('project_number',$item->project->code)
                        ->sum(DB::raw('total'));
                    }
                }elseif($request->type==5){
                    if($item->category){
                        return Link::where('category_id',$item->category->category_number)
                        ->sum(DB::raw('total'));
                    }
                }
                return 0;
            })
            ->editColumn('total_targets', function ($item) use ($request) {
                return $item->totalTargets($item->section_id,$request->type);
            })
            ->addColumn('percent', function ($item) use ($today) {
                $total = 0;
                  if($item->initiative){
                    if($item->initiative->type==1)
                   {
                       $total = Link::whereDate('date','<=',$today)
                        ->where('section_code',$item->initiative->code)
                        ->sum('total');
                   }
                   if($item->initiative->type==2)
                   {
                   $project_codes=Project::where('category_id',$item->initiative->category_id)->pluck('code');
                    $total = Link::whereDate('date','<=',$today)
                        ->whereIn('project_number', $project_codes)->orWhere('category_id', $item->initiative->category_id)->sum('total');

                   }
                   if($item->initiative->type==3)
                   {
                       if($item->initiative->project){

                        $total = Link::whereDate('date','<=',$today)
                            ->where('project_number',$item->initiative->project_id)
                            ->sum('total');
                       }
                   }
                }

                if($item->all_targets >0){

                    $achieved = round(($total/$item->all_targets) * 100,2);
                }else{
                    $achieved = round($item->all_targets);
                }
                if($achieved < 50){
                      return ' <button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                            '.$achieved.' %
                        </button>';
                }
                if($achieved < 80 && $achieved > 50){
                      return ' <button class="btn btn-sm btn-outline-warning me-1 waves-effect">
                            '.$achieved.' %
                        </button>';
                }
                if($achieved > 80){
                      return ' <button class="btn btn-sm btn-outline-success me-1 waves-effect">
                            '.$achieved.' %
                        </button>';
                }
            })
            ->rawColumns(['section','percent','total_targets','achieved','type'])
            ->make(true);
    }
    public function select(Request $request)
    {

       $data = Target::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                }
            })
            ->select('id', 'name AS text')
            ->take(10)
            ->get();
        return response()->json($data);
    }



}

?>

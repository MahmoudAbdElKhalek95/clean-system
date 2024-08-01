<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\WhatsappPhone;
use App\Models\ProjectPhone;
use App\Traits\UserPermission;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ProjectPhoneRequest;
use App\Models\Link;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectPhoneController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.project_phones.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.project_phones.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = ProjectPhone::findOrFail($id);
        return view('admin.pages.project_phones.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = ProjectPhone::findOrFail($id);
        return view('admin.pages.project_phones.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = ProjectPhone::findOrFail($id);
        if ($item->delete()) {
            flash(__('admin.deleted'))->success();
        }
        return redirect()->route('project_phones.index');
    }

    public function store(ProjectPhoneRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('admin.created'))->success();
        }
        return redirect()->route('project_phones.index');
    }

    public function update(ProjectPhoneRequest $request, $id)
    {
        $this->userpermission();
        ProjectPhone::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('admin.updated'))->success();
        }
        return redirect()->route('project_phones.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new ProjectPhone() : ProjectPhone::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = ProjectPhone::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category ? $item->category->name : '';
            })

            ->addColumn('project', function ($item) {
                return $item->project ? $item->project->name : '';
            })
            ->rawColumns(['category','project' ])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = ProjectPhone::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'name AS text')
             ->get();
        return response()->json($data);
    }


    public function category_phones(Request $request)
    {

        return view('admin.pages.project_phones.category_phones', get_defined_vars());

    }


    public function category_phones_store(Request $request)
    {
        $category_id = $request->category_id;
        $phone_numbers = $request->phone_numbers;
        $used_project_ids = ProjectPhone::pluck('project_id')->toArray();
        $project_ids = [];
        $pojects = Project::where('category_id', $category_id)->whereNotIn('code', $used_project_ids) ->get();
        foreach($pojects  as  $item) {
            if($item->getPercent()  < 100) {
                array_push($project_ids, $item->code);
            }
        }
        $links = Link::with('project')->whereIn('project_number', $project_ids)->limit($phone_numbers)->get();
        foreach($links  as $item) {
            $phone_exist = ProjectPhone::where('phone', $item->phone)->where('project_id', $item->project_number)->first();
            if(! $phone_exist) {
                $new_row =  new ProjectPhone();
                $new_row->project_id = $item->project_number;  // project id = project code  not id
                $new_row->category_id = $request->category_id;
                $new_row->phone = $item->phone;
                $new_row->status = 0;
                $new_row->save();
            }
        }
        return redirect()->route('project_phones.index');
    }

    public function sendMessage()
    {
        $phones = ProjectPhone::with('project')->where('status', 0)->get();
        $whats=new WhatsappService();
        foreach($phones as $item) {
            $project_link = "https://give.qb.org.sa/P/" . $item->project->code;
            Log::info($item->phone);
            $send=$whats->whatsTemplate(formate_phone_number($item->phone), $item->project->name, $project_link);
            Log::info($send);
            $item->status = 1;
            $item->save();
        }

    }

}

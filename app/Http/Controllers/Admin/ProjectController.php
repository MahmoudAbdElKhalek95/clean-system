<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Link;
use App\Models\Project;
use App\Models\ProjectCode;
use App\Models\ProjectPhone;
use App\Models\ResendPhone;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.projects.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.projects.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = Project::findOrFail($id);
        return view('admin.pages.projects.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Project::findOrFail($id);
        return view('admin.pages.projects.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = Project::findOrFail($id);
        if ($item->delete()) {
            flash(__('projects.messages.deleted'))->success();
        }
        return redirect()->route('projects.index');
    }

    public function store(ProjectRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('projects.messages.created'))->success();
        }
        return redirect()->route('projects.index');
    }

    public function update(ProjectRequest $request, $id)
    {
        Project::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('projects.messages.updated'))->success();
        }
        return redirect()->route('projects.index');
    }
    public function code(Request $request)
    {
        if ($request->ajax()) {
            $data = ProjectCode::with(['project'])->select('*');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('project', function ($item) {
                return $item->project ? $item->project->name : '';
            })
            ->rawColumns(['project'])
            ->make(true);
        }
        return view('admin.pages.projects.code');
    }

    public function updatecode(Request $request)
    {
        $row = ProjectCode::where('project_id', $request->project_id)->first();
        if($row) {
            $input = [
                'project_id' => $request->project_id,
                'code' => $request->code
            ];
            $row->update($input);
            flash(__('projects.messages.updated'))->success();
        } else {
            $input = [
                'project_id' => $request->project_id,
                'code' => $request->code
            ];
            ProjectCode::create($input);
            flash(__('projects.messages.created'))->success();
        }
        return redirect()->route('projects.code');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Project() : Project::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if(!$request->filled('not_active')) {
            $item->not_active = 0;
        }
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function exportProject(Request $request)
    {

        $data = Project::with('category')->where(function ($query) use ($request) {
            if ($request->filled('category_id')) {
                $query->where('projects.category_id', $request->category_id);
            }
            if ($request->filled('last_operation') && in_array($request->last_operation, [1,2,3])) {
                $query->where('links.created_at', '>=', (Carbon::now()->subDays($request->last_operation)->toDateTimeString()));
            }

        })->leftJoin('links', 'links.project_number', 'projects.code')
              ->groupBy('projects.id')
              ->select([
            'projects.*',
            DB::raw('sum(links.total) as total_done'),
            ]);
        if ($request->filled('from') && $request->filled('to')) {
            $from = $request->from;
            $to = $request->to;
            $data = $data->havingRaw('(((projects.price*projects.quantityInStock)/sum(links.total)>' . $from . ')) AND ((projects.price*projects.quantityInStock)/sum(links.total)<' . $to . ')');
        }
        return FastExcel::data($data->get())->download('projects.xlsx', function ($item) {
            $operation = Link::where('project_number', $item->code)->orderBy('id', 'DESC')->first();
            $last_date = $operation ? $operation->created_at->format('Y-m-d H:i') : '';
            $target = $item->price * $item->quantityInStock;
            $percent = 0;
            $status = __('projects.statuses.2');
            if($target > 0) {
                $percent = round(($item->total_done / $target) * 100, 2);
            }
            if($percent >= 100) {
                $status = __('projects.statuses.1');

            }
            $number_donor = Link::where('project_number', $item->code)->groupBy('phone')->select(DB::raw('count(id)'))->get();

            return [
                __('projects.code') => $item->code ?? '',
                __('projects.name') => $item->name ?? '',
                __('projects.category') => $item->category ? $item->category->name : '',
                __('projects.last_date') => $last_date ?? '',
                __('projects.status') => $status ?? '',
                __('projects.quantityInStock') => $item->quantityInStock ?? '',
                __('projects.price') => $item->price ?? '',
                __('projects.totalSalesTarget') => $target ?? '',
                __('projects.totalSalesDone') => $item->total_done ?? '',
                __('projects.percent') => $percent ?? '',
                __('projects.number_donor') => count($number_donor) ?? 0,
            ];
        });
    }
    public function updatePhones(Request $request)
    {
        $codes = Project::where('send_status', 1)->pluck('code')->toArray();
        $number_donors = Link::whereIn('project_number', $codes)->groupBy('phone')->pluck('phone')->toArray();
        foreach($number_donors as $number) {
            ResendPhone::create([
                'phone' => $number,
                'project_id' => 1
            ]);
        }

        return back();
    }
    public function resendProjects(Request $request)
    {
        $project = Project::findOrFail($request->main_project_id);
        $phones = ResendPhone::pluck('phone')->toArray();
        $number_donors = Link::where('project_number', $project->code)->whereNotIn('phone', $phones)->groupBy('phone')->pluck('phone')->toArray();
        $whats = new WhatsappService();

        foreach($number_donors as $number) {
            ResendPhone::create([
                'project_id' => $project->id,
                'phone' => $number,
            ]);
            $whats->whatsTemplate(formate_phone_number($number), $project->name);
        }
        $project->update(['send_status' => 1]);
        flash(__('admin.messages.updated'))->success();
        return back();
    }
    public function list(Request $request)
    {
        $data = Project::with('category')->where(function ($query) use ($request) {
            if ($request->filled('category_id')) {
                $query->where('projects.category_id', $request->category_id);
            }
            if ($request->filled('last_operation') && in_array($request->last_operation, [1,2,3])) {
                $query->where('links.created_at', '>=', (Carbon::now()->subDays($request->last_operation)->toDateTimeString()));
            }
        })->leftJoin('links', 'links.project_number', 'projects.code')
            ->groupBy('projects.id')
            ->select([
            'projects.*',
            DB::raw('sum(links.total) as total_done'),
            ]);
        if ($request->filled('from') && $request->filled('to')) {
            $from = $request->from;
            $to = $request->to;
            $data = $data->havingRaw('(((projects.price*projects.quantityInStock)/sum(links.total)>' . $from . ')) AND ((projects.price*projects.quantityInStock)/sum(links.total)<' . $to . ')');
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category ? $item->category->name : '';
            })
            ->addColumn('last_date', function ($item) {
                $operation = Link::where('project_number', $item->code)->orderBy('id', 'DESC')->first();
                return $operation ?  ($operation->created_at ?$operation->created_at->format('Y-m-d H:i') : ''): '';
            })
            ->addColumn('number_donor', function ($item) {
                $number_donor = Link::where('project_number', $item->code)->groupBy('phone')->select(DB::raw('count(id)'))->get();
                return count($number_donor);
            })
            ->addColumn('total_target', function ($item) {
                return $item->price * $item->quantityInStock;
            })
            ->rawColumns(['category','total_target','last_date','number_donor'])
            ->make(true);
    }
    public function send(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('compleated_projects_view')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sendstatus', function ($item) {
                    if($item->send_status == 0) {
                        return ' <button class="btn btn-sm btn-outline-danger me-1 waves-effect">' . __('projects.send_status.' . $item->send_status) . '</button>';
                    }
                    return ' <button class="btn btn-sm btn-outline-success me-1 waves-effect">' . __('projects.send_status.' . $item->send_status) . '</button>';
                })
                ->rawColumns(['sendstatus'])
                ->make(true);
        }
        return view('admin.pages.projects.send');
    }


    public function select(Request $request)
    {
        $data = Project::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('category_id')) {
                    $query->whereIn('category_id', explode(',', $request->category_id));
                }
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                    $query->OrWhere('code', 'LIKE', '%' . $request->q . '%');
                }
            })->select('id', 'name AS text')
            ->get();

        return response()->json($data);
    }
    public function selectNumber(Request $request)
    {

        $data = Project::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }

                if ($request->filled('category_id')) {
                    $query->whereIn('category_id', explode(',', $request->category_id));
                }

             })
             ->select('code AS id', 'name AS text')
             ->get();
        return response()->json($data);
    }
}

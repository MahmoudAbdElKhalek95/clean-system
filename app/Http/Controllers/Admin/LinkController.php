<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Imports\LinkExcelImport;
use App\Models\Archive;
use App\Models\ClientUser;
use App\Models\Link;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Yajra\DataTables\Facades\DataTables;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.links.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.links.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = Link::findOrFail($id);
        return view('admin.pages.links.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Link::findOrFail($id);
        return view('admin.pages.links.show', get_defined_vars());
    }

    protected function import(Request $request)
    {
        // try {

        $object = new LinkExcelImport();

        Excel::import($object, request()->file('file'));
        flash(__('targets.excel_uploaded'))->success();
        return back();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     flash($e->getMessage())->error();
        // }
    }
    public function destroy($id)
    {
        $item = Link::where('id', '!=', auth()->id())->findOrFail($id);
        if ($item->delete()) {
            flash(__('links.messages.deleted'))->success();
        }
        return redirect()->route('links.index');
    }
    public function list(Request $request)
    {

        $usersids = [];
        $userscodes = [];
        if (session()->has('responsiveId')) {
            $usersids = ClientUser::where('user_id', session('responsiveId'))->pluck('client_id')->toArray();
            $userscodes = User::whereIn('id', $usersids)->pluck('code')->toArray();
        }

        $data = Link::where(function ($query) use ($request, $usersids, $userscodes) {
            if (session()->has('responsiveId')) {
                $query->whereIn('links.user_id', $usersids)
                    ->orWhere(function ($q) use ($userscodes) {
                        $q->whereIn('links.code', $userscodes);
                    });
            }
            if (auth()->user()->type == User::TYPE_CLIENT) {
                $query->where('links.user_id', auth()->user()->id);
                $query->orWhere('links.code', auth()->user()->id);
            }
            if ($request->filled('category_id')) {
                $query->where('links.category_id', $request->category_id);
            }
            if ($request->filled('user_id')) {
                $query->where('links.user_id', $request->user_id);
            }

            if ($request->filled('project_number')) {
                $query->where('links.project_number', $request->project_number);
            }

        })->select('links.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function ($item) {
                return $item->user ? $item->user->name : '';
            })
            ->addColumn('section', function ($item) {
                return $item->section ? $item->section->name : '';
            })
            ->addColumn('project_percentage', function ($item) {
                return $item->project ? $item->project->getPercent() : 0;
            })
            ->addColumn('type', function ($item) {
                return ' <button  class="btn btn-sm btn-outline-primary me-1 waves-effect">
                        ' . __('links.types.' . $item->oprtation_type) . '
                    </button>';
            })
            ->rawColumns(['user','type'])
            ->make(true);
    }

    public function exportLink(Request $request)
    {
        $usersids = [];
        $userscodes = [];
        $archive = Archive::where('status', 1)->first();
        $data['archive'] = $archive;


        if (session()->has('responsiveId')) {
            $usersids = ClientUser::where('user_id', session('responsiveId'))->pluck('client_id')->toArray();
            $userscodes = User::whereIn('id', $usersids)->pluck('code')->toArray();
        }

        $data = Link::leftJoin('projects', 'projects.code', 'links.project_number')
        ->where(function ($query) use ($request, $usersids, $userscodes) {
            if (session()->has('responsiveId')) {
                $query->whereIn('links.user_id', $usersids)
                    ->orWhere(function ($q) use ($userscodes) {
                        $q->whereIn('links.code', $userscodes);
                    });
            }
            if (auth()->user()->type == User::TYPE_CLIENT) {
                $query->where('links.user_id', auth()->user()->id);
                $query->orWhere('links.code', auth()->user()->id);
            }
            if ($request->filled('category_id')) {
                $query->where('projects.category_id', $request->category_id);
            }
            if ($request->filled('user_id')) {
                $query->where('links.user_id', $request->user_id);
            }

            if ($request->filled('project_number')) {
                $query->where('links.project_number', $request->project_number);
            }
        })->where('archive_id', session('activeArchive'))->select('links.*');

        return FastExcel::data($data->get())->download('links.xlsx', function ($item) {
            return [
                __('links.project_name') => $item->project_name,
                __('links.project_percentage') => $item->project ? $item->project->getPercent() : 0,
                __('links.project_dep_name') => $item->project_dep_name,
                __('links.phone') => $item->phone,
                __('links.total') => $item->total,
                __('links.user') => $item->user ? $item->user->name : '',
                __('links.code') => $item->code,
                __('links.date') => $item->date,
                __('links.type') => __('links.types.' . $item->oprtation_type),
            ];
        });
    }
    public function select(Request $request)
    {
        $data = Link::distinct()
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


    public function store(LinkRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('links.messages.created'))->success();
        }
        return redirect()->route('links.index');
    }


    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Link() : Link::find($id);
        $project = Project::find($request->project_id);
        $input = [
              'project_name' => $project->name ?? '',
              'project_dep_name' => $project->category->name ?? '',
              'amount' => $request->amount,
              'price' => $request->price,
              'ptone' => $request->phone,
              'total' => $request->amount * $request->price,
              'date' => $request->date,
              'project_number' => $project->code ?? '',
            //  'section_id' =>  $request->section_id,
              'code' => $request->code,
            //  'user_id' => $request->user_id,
              'oprtation_type' => Link::TYPE_ACCOUNT
              ];
        $item = $item->fill($input);
        if ($item->save()) {
            return $item;
        }
        return null;
    }



}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\WhatsappPhone;
use App\Models\ShareLink;
use App\Traits\UserPermission;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ShareLinkRequest;
use App\Models\Project;

class ShareLinkController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.share_links.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        $projects = Project::get() ;
        return view('admin.pages.share_links.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = ShareLink::findOrFail($id);
        return view('admin.pages.share_links.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = ShareLink::findOrFail($id);
        return view('admin.pages.share_links.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = ShareLink::findOrFail($id);
        if ($item->delete()) {
            flash(__('admin.deleted'))->success();
        }
        return redirect()->route('share_links.index');
    }

    public function store(ShareLinkRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('admin.created'))->success();
        }
        return redirect()->route('share_links.index');
    }

    public function update(ShareLinkRequest $request, $id)
    {
        $this->userpermission();
        ShareLink::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('admin.updated'))->success();
        }
        return redirect()->route('share_links.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new ShareLink() : ShareLink::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = ShareLink::select('*');
        return DataTables::of($data)
        ->addColumn('project', function ($item) {
            return $item->project ? $item->project->name : '';
        })
        ->addColumn('type', function ($item) {
            return ' <button  class="btn btn-sm btn-outline-primary me-1 waves-effect">
                    '. __('admin.sharetypes.'.$item->type).'
                </button>';
        })
        ->addIndexColumn()
        ->rawColumns(['project','type'])
        ->make(true);
    }

    public function select(Request $request)
    {

        $data = ShareLink::distinct()
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

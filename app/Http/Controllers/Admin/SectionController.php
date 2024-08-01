<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Traits\UserPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.sections.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.sections.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Section::findOrFail($id);
        return view('admin.pages.sections.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Section::findOrFail($id);
        return view('admin.pages.sections.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Section::findOrFail($id);
        if ($item->delete()) {
            flash(__('sections.messages.deleted'))->success();
        }
        return redirect()->route('sections.index');
    }

    public function store(SectionRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('sections.messages.created'))->success();
        }
        return redirect()->route('sections.index');
    }

    public function update(SectionRequest $request, $id)
    {
        $this->userpermission();
        Section::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('sections.messages.updated'))->success();
        }
        return redirect()->route('sections.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Section() : Section::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);

        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Section::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('type', function ($item) {
                return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                '.__('sections.types.'.$item->section_type).'
                        </button>';
            })
            ->rawColumns(['type'])
            ->make(true);
    }

    public function select(Request $request)
    {
       $data = Section::distinct()
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

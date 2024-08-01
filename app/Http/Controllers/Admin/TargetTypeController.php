<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TargetTypeRequest;
use App\Models\TargetType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TargetTypeController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.target_types.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.target_types.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = TargetType::findOrFail($id);
        return view('admin.pages.target_types.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = TargetType::findOrFail($id);
        return view('admin.pages.target_types.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = TargetType::findOrFail($id);
        if ($item->delete()) {
            flash(__('target_types.messages.deleted'))->success();
        }
        return redirect()->route('target_types.index');
    }

    public function store(TargetTypeRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('target_types.messages.created'))->success();
        }
        return redirect()->route('target_types.index');
    }

    public function update(TargetTypeRequest $request, $id)
    {
        TargetType::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('target_types.messages.updated'))->success();
        }
        return redirect()->route('target_types.index');
    }


    protected function processForm($request, $id = null)
    {
        try {
            $item = $id == null ? new TargetType() : TargetType::find($id);
            $data= $request->except(['_token', '_method']);
            $item = $item->fill($data);
            if(!$request->filled('status')){
                    $item->status = 0;
            }
            if ($item->save()) {
                return $item;
            }
            return null;
        }catch(Exception $e){
            flash($e->getMessage())->error();
            return null;
        }
    }


    public function list(Request $request)
    {
        $data = TargetType::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($item) {
                return '<button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                '.__('target_types.statuses.'.$item->status).'
                        </button>';

        })
        ->rawColumns(['status'])
        ->make(true);
    }


    public function select(Request $request)
    {

        $data = TargetType::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                     $query->OrWhere('code', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'name AS text')
             ->get();
        return response()->json($data);
    }

}

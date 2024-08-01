<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
class CategoryController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.categories.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.categories.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Category::findOrFail($id);
        return view('admin.pages.categories.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Category::findOrFail($id);
        return view('admin.pages.categories.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Category::findOrFail($id);
        if ($item->delete()) {
            flash(__('categories.messages.deleted'))->success();
        }
        return redirect()->route('categories.index');
    }

    public function store(CategoryRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('categories.messages.created'))->success();
        }
        return redirect()->route('categories.index');
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->userpermission();
        Category::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('categories.messages.updated'))->success();
        }
        return redirect()->route('categories.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Category() : Category::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if(!$request->filled('not_active')){
            $item->not_active = 0;
        }
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Category::with('phone')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('phone', function ($item) {
                return $item->phone ? $item->phone->name : '';
            })
            ->rawColumns(['phone'])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Category::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                }
            })
            ->select('id', 'name AS text')
            ->get();
        return response()->json($data);
    }

 public function whatsapp(Request $request, $id = null)
    {

        if ($request->ajax()) {
            $data = WhatsappSetting::with('category')->where('category_id', $request->category_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($item) {
                    return $item->category->name ?? '';
                })

                ->rawColumns(['category'])
                ->make(true);
        }
        $item = Category::findOrFail($id);
        return view('admin.pages.categories.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats=WhatsappSetting::where('category_id',$request->category_id)->first();
        $item = $whats == null ? new WhatsappSetting() : $whats;
        $data= $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);
        $item->status = 0;
        if ($item->save()) {
            flash(__('users.messages.updated'))->success();
        }
        return back();
    }


}

?>

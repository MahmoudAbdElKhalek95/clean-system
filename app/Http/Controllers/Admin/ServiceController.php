<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;

class ServiceController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.service.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.service.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Service::findOrFail($id);
        return view('admin.pages.service.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Service::findOrFail($id);
        return view('admin.pages.service.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Service::findOrFail($id);
        if ($item->delete()) {
            flash(__('service.messages.deleted'))->success();
        }
        return redirect()->route('service.index');
    }

    public function store(ServiceRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('service.messages.created'))->success();
        }
        return redirect()->route('service.index');
    }

    public function update(ServiceRequest $request, $id)
    {
        $this->userpermission();
        Service::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('service.messages.updated'))->success();
        }
        return redirect()->route('service.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Service() : Service::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Service::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
           // ->rawColumns()
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Service::distinct()
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
            $data = WhatsappSetting::with('service')->where('service_id', $request->service_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('service', function ($item) {
                    return $item->service->name ?? '';
                })

                ->rawColumns(['service'])
                ->make(true);
        }
        $item = Service::findOrFail($id);
        return view('admin.pages.service.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats=WhatsappSetting::where('service_id',$request->service_id)->first();
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

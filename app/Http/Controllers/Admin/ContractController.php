<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
class ContractController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.contract.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.contract.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Contract::findOrFail($id);
        return view('admin.pages.contract.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Contract::findOrFail($id);
        return view('admin.pages.contract.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Contract::findOrFail($id);
        if ($item->delete()) {
            flash(__('contract.messages.deleted'))->success();
        }
        return redirect()->route('contract.index');
    }

    public function store(ContractRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('contract.messages.created'))->success();
        }
        return redirect()->route('contract.index');
    }

    public function update(ContractRequest $request, $id)
    {
        $this->userpermission();
        Contract::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('contract.messages.updated'))->success();
        }
        return redirect()->route('contract.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Contract() : Contract::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Contract::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
           // ->rawColumns()
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Contract::distinct()
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
            $data = WhatsappSetting::with('contract')->where('contract_id', $request->contract_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('contract', function ($item) {
                    return $item->contract->name ?? '';
                })

                ->rawColumns(['contract'])
                ->make(true);
        }
        $item = Contract::findOrFail($id);
        return view('admin.pages.contract.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats=WhatsappSetting::where('contract_id',$request->contract_id)->first();
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

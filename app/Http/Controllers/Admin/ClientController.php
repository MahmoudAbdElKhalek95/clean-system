<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use App\Imports\ClientExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB ;

class ClientController extends Controller  /// التصنيفات
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.client.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.client.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Client::findOrFail($id);
        return view('admin.pages.client.create_edit', get_defined_vars());
    }

    protected function import(Request $request)
    {
        try{
            $data = [
                'type_id'=>$request->type_id,

            ];
            $object = new ClientExcelImport($data);
            Excel::import($object, request()->file('file'));
            flash(__('targets.excel_uploaded'))->success();
            return back();
         } catch (\Exception $e) {
            DB::rollback();
            flash($e->getMessage())->error();
        }
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Client::findOrFail($id);
        return view('admin.pages.client.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Client::findOrFail($id);
        if ($item->delete()) {
            flash(__('client.messages.deleted'))->success();
        }
        return redirect()->route('client.index');
    }

    public function store(ClientRequest $request)
    {
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('client.messages.created'))->success();
        }
        return redirect()->route('client.index');
    }

    public function update(ClientRequest $request, $id)
    {
        $this->userpermission();
        Client::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('client.messages.updated'))->success();
        }
        return redirect()->route('client.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Client() : Client::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);

        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Client::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('type_id', function ($item) {
                return $item->type? $item->type->name : '';
            })

            ->make(true);
    }

    public function select(Request $request)
    {

        $data = Client::distinct()
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

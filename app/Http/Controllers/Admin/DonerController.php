<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonerRequest;
use App\Models\Doner;
use App\Models\DonerType;
use App\Models\DonnerAmount;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DonerController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.doners.index', get_defined_vars());
    }

    public function create()
    {
        return view('admin.pages.doners.create_edit', get_defined_vars());

        // $donners = Link::groupBy('phone')->whereNotNull('phone')->where('phone','!=','')->select(['phone',DB::raw('sum(total) as total'),DB::raw('count(*) as totalamount')])->toSql();
        // dd($donors);
        // foreach ($donners as $link) {
        //     DonnerAmount::updateOrCreate([
        //             'phone'   => $link->phone,
        //         ], [
        //             'phone'   => $link->phone,
        //             'total'     => $link->total,
        //             'amount'     => $link->totalamount,
        //         ]);
        //         dd($link);
        // }
        // flash(__('doners.messages.updated'))->success();
        // return back();
    }

    public function edit($id)
    {
        $item = Doner::findOrFail($id);
        return view('admin.pages.doners.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = Doner::findOrFail($id);
        return view('admin.pages.doners.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = Doner::findOrFail($id);
        if ($item->delete()) {
            flash(__('doners.messages.deleted'))->success();
        }
        return redirect()->route('doners.index');
    }

    public function store(DonerRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('doners.messages.created'))->success();
        }
        return redirect()->route('doners.index');
    }

    public function update(DonerRequest $request, $id)
    {
        Doner::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('doners.messages.updated'))->success();
        }
        return redirect()->route('doners.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Doner() : Doner::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);

        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $data = Doner::with('donerType')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()

             ->editColumn('type_text', function ($item) {
                return __('doners.type_text.'.$item->type);
            })
            ->editColumn('doner_type', function ($item) {
                $total = $item->donerType ? $item->donerType->total : 0;
                return  $item->doner_type($total);
            })
            ->editColumn('amounts', function ($item) {
                return  $item->donerType ? $item->donerType->total : 0;
            })
            ->rawColumns(['type_text' , 'doner_type'])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = Doner::distinct()
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Http\Requests\rateRequest;
use App\Models\Rate;
use App\Models\Rtae;
use App\Models\VisitDetail;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class RateController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {

       // return Rate::with('user')->first() ;
        $this->userpermission();
        return view('admin.pages.rate.index', get_defined_vars());
    }

    public function create()
    {

        $visit_details = VisitDetail::where('id'  ,  request('visit_detail_id')  )->first() ;
       // $this->userpermission();
        return view('admin.pages.rate.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Rate::findOrFail($id);
        return view('admin.pages.rate.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Rate::findOrFail($id);
        return view('admin.pages.rate.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Rate::findOrFail($id);
        if ($item->delete()) {
            flash(__('rate.messages.deleted'))->success();
        }
        return redirect()->route('rate.index');
    }

    public function store(Request $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('rate.messages.created'))->success();
        }
        return redirect()->route('rate.index');
    }

    public function update(Request $request, $id)
    {
        $this->userpermission();
        Rate::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('rate.messages.updated'))->success();
        }
        return redirect()->route('rate.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Rate() : Rate::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

      
        $data = Rate::with( ['super' , 'manager'])->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('super', function ($item) {
                return $item->super ? $item->super->name : '';
            })
            ->AddColumn('manager', function ($item) {
                return $item->manager ? $item->manager->name : '';
            })
           /* ->AddColumn('vist_details', function ($item) {
             
               // $link = "<a href='{{route("rate_details", $item->id  ) }}>" ;
               $link = "<a class='btn btn-success'  href ='{{route('rate_details.index' , $item->id )}}'>{{ __('rate_details.plural') }} </a> " ;

               return $link ;


            })*/
            ->rawColumns(['super' , 'manager' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Rate::distinct()
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitRequest;
use App\Models\Visit;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class VisitController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {

       // return Visit::with('user')->first() ;
        $this->userpermission();
        return view('admin.pages.visit.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.visit.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = Visit::findOrFail($id);
        return view('admin.pages.visit.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Visit::findOrFail($id);
        return view('admin.pages.visit.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Visit::findOrFail($id);
        if ($item->delete()) {
            flash(__('visit.messages.deleted'))->success();
        }
        return redirect()->route('visit.index');
    }

    public function store(VisitRequest $request)
    {

       // return $request->all(); 
        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('visit.messages.created'))->success();
        }
        return redirect()->route('visit.index');
    }

    public function update(VisitRequest $request, $id)
    {
        $this->userpermission();
        Visit::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('visit.messages.updated'))->success();
        }
        return redirect()->route('visit.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Visit() : Visit::find($id);
        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

      
        $data = Visit::with('user')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('user', function ($item) {
                return $item->user ? $item->user->name : '';
            })
           /* ->AddColumn('vist_details', function ($item) {
             
               // $link = "<a href='{{route("visit_details", $item->id  ) }}>" ;
               $link = "<a class='btn btn-success'  href ='{{route('visit_details.index' , $item->id )}}'>{{ __('visit_details.plural') }} </a> " ;

               return $link ;


            })*/
            ->rawColumns(['user' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = Visit::distinct()
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

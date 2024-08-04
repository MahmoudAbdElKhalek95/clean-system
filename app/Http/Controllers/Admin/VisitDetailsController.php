<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitDetailRequest;
use App\Models\Visit;
use App\Models\VisitDetail;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;

class VisitDetailsController extends Controller
{
    use UserPermission;
    public function index(Request $request  )
    {

      // return  $rate_link = route('rate.create')."?manager_id=1."&super_id=".2."&visit_detail_id=".1;


       // return VisitDetail::with('user')->first() ;
       // $visit = Visit::find(  $visit_id) ;
        $this->userpermission();
        return view('admin.pages.visit_details.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.visit_details.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $this->userpermission();
        $item = VisitDetail::findOrFail($id);
        return view('admin.pages.visit_details.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = VisitDetail::findOrFail($id);
        return view('admin.pages.visit_details.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = VisitDetail::findOrFail($id);
        if ($item->delete()) {
            flash(__('visit_details.messages.deleted'))->success();
        }
        return redirect()->route('visit_details.index');
    }

    public function store(VisitDetailRequest $request)
    {

       // return $request->all(); 

    // return   $method = $request->method();   /// POST 


        $this->userpermission();
        if ($this->processForm($request)) {
            flash(__('visit_details.messages.created'))->success();
        }
        return redirect()->route('visit_details.index');
    }

    public function update(VisitDetailRequest $request, $id)
    {
        $this->userpermission();
        VisitDetail::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('visit_details.messages.updated'))->success();
        }
        return redirect()->route('visit_details.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new VisitDetail() : VisitDetail::find($id);

     //   $method = $request->method();   /// POST 
      

        $data= $request->except(['_token', '_method']);
        $item = $item->fill($data);
     
    

        if ($item->save()) {
          
            if(  $id == null   )
            {
    
    
               $manager_id =  $item->school->manager->id ;
             // $rate_link = route('rate.create')."?manager_id=".$manager_id."&super_id=". $item->user_id."&visit_detail_id=".$item->id;
              $rate_link = route('rate.create')."?visit_detail_id=".$item->id;
             
              //  return $item->date ;
              /////  مدير المدرسه  ///////////////////
                $phone = $item->school->manager->phone ?? 0 ;
               ////// المشرف 
                $super_name = $item->user->name ?? 0 ;
    
                $message = "تمت زيارتكم من قبل المشرف ";
                $message .= "   $super_name  ";
                $message .= " بتاريخ ";
                $message .= " $item->date";
                $message .= " الرجاء تقيم الزياره ";
                $message .= "  $rate_link ";
    
    
                send_whatsapp_message( $phone ,     $message   ) ;
     
             
            }
        
            return $item;
        }


      

      
        return null;
    }

    public function list(Request $request   )
    {

      
        $data = VisitDetail::with('user')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->AddColumn('user', function ($item) {
                return $item->user ? $item->user->name : '';
            })
            ->AddColumn('visit', function ($item) {
                return $item->visit ? $item->visit->visit_number : '';
            })
            ->AddColumn('school', function ($item) {
                return $item->school ? $item->school->name : '';
            })
            ->rawColumns(['user' , 'visit' , 'schoool' ])
            ->make(true);
    }

    public function select(Request $request)
    {

       $data = VisitDetail::distinct()
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

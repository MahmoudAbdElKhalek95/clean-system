<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitRequest;
use App\Models\Visit;
use App\Models\VisitDetail;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use DateTime;

class VisitController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {

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
            ->AddColumn('buttun', function ($item) {
             
                return  "<a class='btn btn-success'  href ='".route('visit_details.index' , $item->id )."'>تفاصيل الزيارات </a> " ;

            })
            ->rawColumns(['buttun' , 'user'])
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

    public function supervisor_visit_report(  Request $request )
    {

   
        if($request->ajax()) {

            $data = VisitDetail::with('user')
           ->where(function ($query) use ($request) {
                 if ($request->filled('user_id')) {
                      $query->where('user_id',  $request->user_id);
                  }
            })
           ->groupBy('user_id')->select('user_id');
             return DataTables::of($data)
             ->addIndexColumn()
             ->AddColumn('user', function ($item) {
                  return $item->user ? $item->user->name : '';
               })
           
              ->AddColumn('day_visit_count', function ($item) {
                $count = VisitDetail::where('date' ,  date('Y-m-d'))->where('user_id' ,  $item->user_id)->count() ;
                return $count ;
              })

              ->AddColumn('week_visit_count', function ($item) {
                $week = [  start_of_week()  ,   end_of_week()    ] ;
                $count = VisitDetail::whereBetween('date' ,  $week   )->where('user_id' ,  $item->user_id)->count() ;
                return $count ;
              })

              ->AddColumn('month_visit_count', function ($item) {
                $first = new DateTime('first day of this month');
                $start_month =   $first->format('Y-m-d');

                $end = new DateTime('last day of this month');
                $end_month =   $end->format('Y-m-d');
              
                $month = [  $start_month   ,    $end_month   ] ;
                $count = VisitDetail::whereBetween('date' ,  $month   )->where('user_id' ,  $item->user_id)->count() ;
                return $count ;
              })

              ->AddColumn('year_visit_count', function ($item) {
                   $firstDay = strtotime('first day of January ' . date('Y'));
                   $start_year =  date('Y-m-d', $firstDay); // Output: 2024-01-01
                   $lastDay = strtotime('last day of december ' . date('Y'));
                   $end_year =  date('Y-m-d', $lastDay); // Output: 2024-01-01
                   $year = [  $start_year   ,    $end_year   ] ;
                   $count = VisitDetail::whereBetween('date' ,  $year   )->where('user_id' ,  $item->user_id)->count() ;
                   return $count ;
                 })
                ->rawColumns(['user' , 'day_visit_count' , 'week_visit_count' , 'month_visit_count' , 'year_visit_count' ])
                ->make(true);

        }


        
        return view('admin.pages.visit.report', get_defined_vars());

    }


}

?>

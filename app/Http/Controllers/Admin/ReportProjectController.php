<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportProjectController extends Controller
{
    public function index(Request $request)
    {
      
    /*    $c_category_ids = compelte_category_array() ;
        $c_projects_ids =  compelte_project_array() ;
      
         $compelte_project_count = Project::with('category')
         ->whereIn('id' ,  $c_projects_ids )
         //->whereIn('category_id' ,   $c_category_ids )
         ->count() ;

         $unc_category_ids = uncompelte_category_array() ;
         $unc_projects_ids =  uncompelte_project_array() ;
       
          $uncompelte_project_count = Project::with('category')
          ->whereIn('id' ,  $unc_projects_ids )
          //->whereIn('category_id' ,   $unc_category_ids )
          ->count() ;
          */

        return view('admin.pages.report.project_report', get_defined_vars());
    }




    public function list(Request $request)
    {

        $data = Project::with('category')->where(function ($query) use ($request) {
            if ($request->filled('category_id')) {
                $query->where('projects.category_id', $request->category_id);
            }
        })->leftJoin('links', 'links.project_number', 'projects.code')
            ->leftJoin('targets', function ($query) {
                $query->on('projects.id', 'targets.section_id')
                    ->where('targets.type', 4);
            })->groupBy('projects.id')
            ->select([
            'projects.*',
            DB::raw('sum(links.total) as total_done'),
        ]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category?$item->category->name:'';
            })
            ->addColumn('total_target', function ($item) {
                return $item->price* $item->quantityInStock;
            })
            ->rawColumns(['category','total_target'])
            ->make(true);
    }



    public function commplete_project_category(  Request $request )
    {


       // return compelte_category_array() ;
      //  return   ( uncompelte_category_array() ) ;


        return view('admin.pages.report.commplete_project_category', get_defined_vars());




    }


    public function listCompleteCategory(Request $request)
    {


        $category_ids = compelte_category_array() ;
          $data = Category::with('projects')
            ->whereIn('id' , $category_ids ) 
            ->select([
            'id',
            'name'
        ]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('project', function ( $item )use($request) {
                return ' <a  href='. route('CompleteCategoryProjectIndex' , $item->id) .' class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('projects.complete') . '</a>';
            })

            ->rawColumns ( ['project'] )
            ->make(true);
    }



    public function CompleteCategoryProjectIndex(Request $request , $id  )
    {

        $projects_ids =  compelte_project_array() ;
        //return "Asd" ;
         $data = Project::with('category')
         ->whereIn('id' ,  $projects_ids )
        ->where('category_id' , $id    )
        ->get() ;

        return view('admin.pages.report.commplete_project_category_index', get_defined_vars());


    }


 





    public function uncommplete_project_category(  Request $request )
    {

        
        return view('admin.pages.report.uncommplete_project_category', get_defined_vars());


    }

    public function uncommplete_project_button(  Request $request  , $id )
    {

        
      
        return view('admin.pages.report.uncommplete_project_button', get_defined_vars());


    }



    public function listUnCompleteCategory(Request $request)
    {


        $category_ids =  (array) uncompelte_category_array();
        $category_ids = array_unique( uncompelte_category_array() );
        $data = Category::with('projects')
            ->whereIn('id' , $category_ids ) 
            ->select([
            'id',
            'name'
        ]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('project', function ( $item )use($request) {
               /* return ' <a  href='. route('UnCompleteCategoryProjectIndex' , $item->id) .' class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('projects.uncomplete') . '</a>'; */

               return ' <a  href='. route('uncommplete_project_button' , $item->id) .' class="btn btn-sm btn-outline-primary me-1 waves-effect">
                   ' . __('projects.uncomplete') . '</a>';


                            
            })

            ->rawColumns ( ['project'] )
            ->make(true);
    }


    public function UnCompleteCategoryProjectIndex(Request $request , $id  )
    {

        $percent = request('percent') ;

          $projects_ids =  compelte_project_array() ;  ;
      // return    $projects_ids =    uncompelte_project_array(  $percent )  ;
        $data = Project::with('category')
        // ->whereIn('id' ,  $projects_ids ) 
         ->whereNotIn('id' ,  $projects_ids )
        ->where('category_id' , $id    )
        ->get() ;

       
        $filterData_ids = [];

        foreach(  $data as $item  )
        {
            if( $percent == 0 )
            {
              if( $item->getPercent() ==  0    )
              {

                array_push(  $filterData_ids , $item->id ) ;

              }
           } // end  0 percent 

           if( $percent == 1  )
           {

            if( $item->getPercent() >= 1  &&  $item->getPercent() <= 10  )
            {

              array_push(  $filterData_ids , $item->id ) ;

            }

           } // end  1 

           

            if( $percent == 2  )
            {
 
            if( $item->getPercent() >= 11  &&  $item->getPercent() <= 20  )
            {

              array_push(  $filterData_ids , $item->id ) ;

            }

           } // end   2 

           if( $percent == 3  )
           {

           if( $item->getPercent() >= 21  &&  $item->getPercent() <= 30  )
           {

             array_push(  $filterData_ids , $item->id ) ;

           }

          } // end   3

          if( $percent == 4  )
          {

            if( $item->getPercent() >= 31 &&  $item->getPercent() <= 40 )
            {
 
              array_push(  $filterData_ids , $item->id ) ;
 
            }
 
           } // end   4

           if( $percent == 5  )
           {
 
             if( $item->getPercent() >= 41 &&  $item->getPercent() <= 50 )
             {
  
               array_push(  $filterData_ids , $item->id ) ;
  
             }
  
            } // end   5

            if( $percent == 6  )
            {
  
              if( $item->getPercent() >= 51 &&  $item->getPercent() <= 60 )
              {
   
                array_push(  $filterData_ids , $item->id ) ;
   
              }
   
             } // end   6

             if( $percent == 7  )
             {
   
               if( $item->getPercent() >= 61 &&  $item->getPercent() <= 70 )
               {
    
                 array_push(  $filterData_ids , $item->id ) ;
    
               }
    
              } // end   7

              if( $percent == 8  )
              {
    
                if( $item->getPercent() >= 71 &&  $item->getPercent() <= 80 )
                {
     
                  array_push(  $filterData_ids , $item->id ) ;
     
                }
     
               } // end   8

               if( $percent == 9  )
               {
     
                 if( $item->getPercent() >= 81 &&  $item->getPercent() <= 90 )
                 {
      
                   array_push(  $filterData_ids , $item->id ) ;
      
                 }
      
                } // end   9


                if( $percent == 10  )
                {
      
                  if( $item->getPercent() >= 91 &&  $item->getPercent() < 100 )
                  {
       
                    array_push(  $filterData_ids , $item->id ) ;
       
                  }
       
                 } // end   10
  
 

        }


       // return    $filterData_ids  ;


        $new_data =   $data = Project::with('category')->whereIn('id' ,   $filterData_ids  )->get() ;

        return view('admin.pages.report.uncommplete_project_category_index', get_defined_vars());


    }


}


?>

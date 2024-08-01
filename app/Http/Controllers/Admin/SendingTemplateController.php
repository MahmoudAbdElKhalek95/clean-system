<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendingTemplateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SendingTemplate;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Session ;

class SendingTemplateController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.sending_templates.index', get_defined_vars());
    }

    public function create()
    {

        /* $data = SendingTemplate::where('id' , 4 )->first() ;

         dd(  explode(',' , $data->param )  ) ; */

        $this->userpermission();
        return view('admin.pages.sending_templates.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $item = SendingTemplate::findOrFail($id);

        $param1 =  explode(',', $item->param)[0] ;
        $param2 =  explode(',', $item->param)[1] ;
        $param2 =  explode(',', $item->param)[2] ;

        /*    if( $item->var_number == 1  )
            {
                $param1 =  explode(',', $item->param)[0] ;

            }
            if( $item->var_number == 2  )
            {
                $param1 =  explode(',', $item->param)[0] ;
                $param1 =  explode(',', $item->param)[1] ;

            }
            if( $item->var_number == 3  )
            {
                $param1 =  explode(',', $item->param)[0] ;
                $param1 =  explode(',', $item->param)[1] ;
                $param2 =  explode(',', $item->param)[2] ;

            }
            if( $item->var_number == 4  )
            {
                $param1 =  explode(',', $item->param)[0] ;
                $param1 =  explode(',', $item->param)[1] ;
                $param2 =  explode(',', $item->param)[1] ;
                $param3 =  explode(',', $item->param)[2] ;

            }
            if( $item->var_number == 5  )
            {
                $param1 =  explode(',', $item->param)[0] ;
                $param1 =  explode(',', $item->param)[1] ;
                $param2 =  explode(',', $item->param)[1] ;
                $param3 =  explode(',', $item->param)[2] ;
                $param5 =  explode(',', $item->param)[4] ;

            }
            if( $item->var_number == 6  )
            {
                $param1 =  explode(',', $item->param)[0] ;
                $param1 =  explode(',', $item->param)[1] ;
                $param2 =  explode(',', $item->param)[1] ;
                $param3 =  explode(',', $item->param)[2] ;
                $param5 =  explode(',', $item->param)[4] ;
                $param6 =  explode(',', $item->param)[5] ;

            }
            */
        //  $param4 =  explode(',', $item->param)[3] ;
        // $param5 =  explode(',', $item->param)[4] ;
        // $param6 =  explode(',', $item->param)[5] ;


        return view('admin.pages.sending_templates.edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = SendingTemplate::findOrFail($id);
        return view('admin.pages.sending_templates.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = SendingTemplate::findOrFail($id);


        if ($item->delete()) {
            flash(__('sending_templates.messages.deleted'))->success();
        }
        return redirect()->route('sending_templates.index');
    }

    public function store(SendingTemplateRequest $request)
    {


        // return  $request->param ;
        // return $request->all();



        $data = $request->except(['_token', '_method'  , 'photo_question' , 'video_question']);


        /*  if(     $data['var_number'] >  3    )
          {

             flash('message', ' عدد المتغيرات لا يزيد عن 3!')->error();

              return redirect()->route('sending_templates.create') ;
              // ->with('errors' , 'لقد تجاوزت عدد المتغيرات الممسوح بها') ;

             // return back()->with('errors' , 'لقد تجاوزت عدد المتغيرات الممسوح بها') ;

          }*/


        if($data['param'] != null) {
            $data['param'] =  implode(',', $request->param) ;
        }


        // return $data['var'] ;
        /*
               if (    $data['param1'] != "null"   )
               {

                switch ( $data['param1'] ) {
                    case 'project_name':
                        //# code...
                        $data['project_name']  = 'project_name'  ;
                        $data['project_name_order']  =  1   ;
                        break;
                        case 'project_link':
                            //# code...
                            $data['project_link']  = 'project_link'  ;
                            $data['project_link_order']  =  1   ;
                            break;
                            case 'project_percent':
                                //# code...
                                $data['project_percent']  = 'project_percent'  ;
                                $data['project_percent_order']  =  1   ;
                                break;



                      default:
                        # code...
                        break;
                  } //////////// end  var switch

               } ////////////////// end var 1 if

               if (   $data['param2']  != "null"   )
               {

                switch ( $data['param2'] ) {
                    case 'project_name':
                        //# code...
                        $data['project_name']  = 'project_name'  ;
                         $data['project_name_order']  =  2   ;
                        break;
                        case 'project_link':
                            //# code...
                            $data['project_link']  = 'project_link'  ;
                            $data['project_link_order']  =  2   ;
                            break;
                            case 'project_percent':
                                //# code...
                                $data['project_percent']  = 'project_percent'  ;
                                $data['project_percent_order']  =  2   ;
                                break;

                      default:
                        # code...
                        break;
                  } //////////// end  param2 switch

               } ////////////////// end var 2 if

               if (   $data['param3']  != "null"   )
               {

                ///return "Asdddddddddd" ;

                switch ( $data['param3'] ) {
                    case 'project_name':
                        //# code...
                        $data['project_name']  = 'project_name'  ;
                        $data['project_name_order']  =  3   ;
                        break;
                        case 'project_link':
                            //# code...
                            $data['project_link']  = 'project_link'  ;
                            $data['project_link_order']  =  3  ;
                            break;
                            case 'project_percent':
                                //# code...
                                $data['project_percent']  = 'project_percent'  ;
                                $data['project_percent_order']  =  3   ;
                                break;

                      default:
                        # code...
                        break;
                  } //////////// end  param3 switch

               } ////////////////// end var 3 if
               */



        // unset($data["param1"] ,  $data["param2"] , $data["param3"]  );

        // return $data ;
        $this->userpermission();
        if ($this->processForm($data)) {
            flash(__('sending_templates.messages.created'))->success();
        }
        return redirect()->route('sending_templates.index');
    }

    public function update(SendingTemplateRequest $request, $id)
    {
        $data = $request->except(['_token', '_method'  , 'photo_question' , 'video_question']);

        /*
          if(     $data['var_number'] >  3    )
          {

              flash('message', ' عدد المتغيرات لا يزيد عن 3!')->error();

              return redirect()->route('sending_templates.create') ;
              // ->with('errors' , 'لقد تجاوزت عدد المتغيرات الممسوح بها') ;

             // return back()->with('errors' , 'لقد تجاوزت عدد المتغيرات الممسوح بها') ;

          }
          */

        //  unset($data["var"]);
        // return $data ;

        /*

        if (    $data['param1'] != "null"   )
        {

         switch ( $data['param1'] ) {
             case 'project_name':
                 //# code...
                 $data['project_name']  = 'project_name'  ;
                 $data['project_name_order']  =  1   ;
                 break;
                 case 'project_link':
                     //# code...
                     $data['project_link']  = 'project_link'  ;
                     $data['project_link_order']  =  1   ;
                     break;
                     case 'project_percent':
                         //# code...
                         $data['project_percent']  = 'project_percent'  ;
                         $data['project_percent_order']  =  1   ;
                         break;

               default:
                 # code...
                 break;
           } //////////// end  var switch

        } ////////////////// end var 1 if

        if (   $data['param2']  != "null"   )
        {

         switch ( $data['param2'] ) {
             case 'project_name':
                 //# code...
                 $data['project_name']  = 'project_name'  ;
                  $data['project_name_order']  =  2   ;
                 break;
                 case 'project_link':
                     //# code...
                     $data['project_link']  = 'project_link'  ;
                     $data['project_link_order']  =  2   ;
                     break;
                     case 'project_percent':
                         //# code...
                         $data['project_percent']  = 'project_percent'  ;
                         $data['project_percent_order']  =  2   ;
                         break;

               default:
                 # code...
                 break;
           } //////////// end  param2 switch

        } ////////////////// end var 2 if

        if (   $data['param3']  != "null"   )
        {

         ///return "Asdddddddddd" ;

         switch ( $data['param3'] ) {
             case 'project_name':
                 //# code...
                 $data['project_name']  = 'project_name'  ;
                 $data['project_name_order']  =  3   ;
                 break;
                 case 'project_link':
                     //# code...
                     $data['project_link']  = 'project_link'  ;
                     $data['project_link_order']  =  3  ;
                     break;
                     case 'project_percent':
                         //# code...
                         $data['project_percent']  = 'project_percent'  ;
                         $data['project_percent_order']  =  3   ;
                         break;

               default:
                 # code...
                 break;
           } //////////// end  param3 switch

        } ////////////////// end var 3 if

        */


        //  unset($data["param1"] ,  $data["param2"] , $data["param3"]  );

        ///  return $data['project_link'] ;

        if (in_array('project_link', $data) == false) {
            $data["project_link"] = null  ;
            $data["project_link_order"] = null  ;

        }

        if(in_array('project_name', $data) == false) {
            $data["project_name"] = null  ;
            $data["project_name_order"] = null  ;

        }

        if(in_array('project_percent', $data) == false) {
            $data["project_percent"] = null  ;
            $data["project_percent_order"] = null  ;


        }

        // return $data  ;
        SendingTemplate::findOrFail($id);
        if ($this->processForm($data, $id)) {
            flash(__('sending_templates.messages.updated'))->success();
        }
        return redirect()->route('sending_templates.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new SendingTemplate() : SendingTemplate::find($id);
        // $data= $request->except(['_token', '_method'  , 'photo_question' , 'video_question']);



        $item = $item->fill($request);


        if ($item->save()) {

            // $item->param = implode(','  , $request->param ) ;
            if  (!empty($request['photo'])) {

                $item->photo = storeFile($request['photo'], 'sending_templates');
                $item->save();
            }
            if  (!empty($request['video'])) {

                $item->video = storeFile($request['video'], 'sending_templates');
                $item->save();
            }

            return $item;
        }



        return null;
    }

    public function list(Request $request)
    {



        $data = SendingTemplate::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            /*->editColumn('project', function ($item) {
                return $item->project ? $item->project->name : '';
            })*/
            ->addColumn('status_name', function ($item) {
                return $item->status == 1 ? 'متاج' : 'غير متاح';
            })

            ->addColumn('vars', function ($item) {
                //return $item->param ;
                $pramter_arr  = explode(',', $item->param);
                $var_arr = [] ;
                foreach($pramter_arr as $key => $item) {
                    if($item != "null") {
                        $key = $key + 1 ;
                        array_push($var_arr, "(". $item."=>".$key.")") ;
                    }
                }
                if(count($var_arr)  > 1) {
                    return implode('----', $var_arr) ;
                } else {
                    return null ;
                }
            })


            ->addColumn('image', function ($item) {

                return  '<img src="' . $item->image . '" alt="logo" width="100ox" height="100px" >';

            })
            ->editColumn('video', function ($item) {

                //return $item->videos ;
                // return  '<a href="' . $item->video . '" target="_blank"  > فديو </a>';
                return  '<a href="'. $item->videos.'" target="_blank"  > فديو </a>';


            })
            ->rawColumns([ 'image' , 'video'  , 'vars' ])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = SendingTemplate::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('template_name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'template_name AS text')
             ->get();
        return response()->json($data);
    }




}

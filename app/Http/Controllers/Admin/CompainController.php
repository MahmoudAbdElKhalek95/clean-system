<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompainRequest;
use App\Models\Category;
use App\Models\Compain;
use App\Models\CompainHistory;
use App\Models\DonerType;
use App\Models\Link;
use App\Models\Project;
use App\Models\TargetType;
use App\Traits\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;

class CompainController extends Controller
{
    use UserPermission;
    public function index(Request $request)
    {
        $this->userpermission();
        return view('admin.pages.compain.index', get_defined_vars());
    }

    public function create()
    {
        $this->userpermission();
        return view('admin.pages.compain.create_edit', get_defined_vars());
    }

  

    public function edit($id)
    {
        $projects = Project::get() ;
        $this->userpermission();
        $item = Compain::findOrFail($id);
        if( $item->category_id  != null  )
        { 
        $item->categories = Category::whereIn('id' ,  json_decode($item->category_id)  ) ->get() ;
        }
        if( $item->project_id  != null  )
        { 
          $item->projectss = Project::whereIn('id' ,  json_decode($item->project_id )  )->get() ;
        }
        //   return  json_decode($item->marketing_project_id) ;
     if( $item->marketing_project_id  != null  )
     { 
       $item->marketing_projectss = Project::where('id' ,  json_decode($item->marketing_project_id)  )->get() ;
     }
       if( $item->target_type_id  != null  )
       {
          $item->target_types = TargetType::whereIn('id' ,  json_decode($item->target_type_id )  )->get() ;

       }

       if( $item->target_doner_type_id  != null  )
       {
          $item->target_doner_types = DonerType::whereIn('id' ,  json_decode($item->target_doner_type_id )  )->get() ;

       }


       

         
        
        
        return view('admin.pages.compain.edit', get_defined_vars());
    }

    public function show($id)
    {
        $this->userpermission();
        $item = Compain::findOrFail($id);
        return view('admin.pages.compain.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $this->userpermission();
        $item = Compain::findOrFail($id);
        if ($item->delete()) {
            flash(__('compain.messages.deleted'))->success();
        }
        return redirect()->route('compain.index');
    }

    public function store(CompainRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('compain.messages.created'))->success();
        }


        return redirect()->route('compain.index');
    }

    public function update(CompainRequest $request, $id)
    {
        //return $request->all() ;
        $Compain = Compain::findOrFail($id);
        $Compain ->name = $request->name ??  $Compain ->name ;
        $Compain ->code = $request->code ??  $Compain ->code ;
        $Compain ->targets = $request->targets ??  $Compain ->targets ;
        $Compain ->sending_way = $request->sending_way ??  $Compain ->sending_way ;
        
        $Compain ->marketing_project_id = $request->marketing_project_id ??  $Compain ->marketing_project_id ;
        $Compain ->whatsapp_template = $request->whatsapp_template ??  $Compain ->whatsapp_template ;
            

        if($request->filled('project_id')) {
            $Compain->project_id = json_encode($request->project_id)  ;
        }

        if($request->filled('category_id')) {
            $Compain->category_id = json_encode($request->category_id)  ;
        }

        if($request->filled('target_type_id')) {
            $Compain->target_type_id = json_encode($request->target_type_id)  ;
        }


        if($request->filled('target_doner_type_id')) {
            $Compain->target_doner_type_id = json_encode($request->target_doner_type_id)  ;
        }


        $Compain->save() ;

        flash(__('categories.messages.updated'))->success();

      
       /* if ($this->processForm($request, $id)) {
            flash(__('categories.messages.updated'))->success();
        }
        */
        return redirect()->route('compain.index');
    }

    protected function processForm($request, $id = null)
    {

        $item = $id == null ? new Compain() : Compain::find($id);
        $data = $request->except(['_token', '_method']);
        $item = $item->fill($data);
        if($request->filled('project_id')) {
            $item->project_id = json_encode($request->project_id)  ;
        }
        $item->marketing_project_id = $request->marketing_project_id ;


        if($request->filled('category_id')) {
            $item->category_id = json_encode($request->category_id)  ;
        }

        if($request->filled('target_type_id')) {
            $item->target_type_id = json_encode($request->target_type_id)  ;
        }


        if($request->filled('target_doner_type_id')) {
            $item->target_doner_type_id = json_encode($request->target_doner_type_id)  ;
        }
        if ($item->save()) {
            $project = Project::where('id', $request->marketing_project_id)->first();
            $total_links = Link::where('project_number', $project->code)->sum('total') ;
            $add = new CompainHistory() ;
            $add->compain_id = $item->id ;
            $add->marketing_project_id = $request->marketing_project_id ;
            $add->amount_before_compain_start = $total_links ;
            $add->save() ;
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {

        $data = Compain::with('whatsapps', 'marketing_project')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('category', function ($item) {
                return !empty($item->category()) ? $item->category() : '';
            })
            ->editColumn('project', function ($item) {
                return !empty($item->project()) ? $item->project() : '';
            })
            ->editColumn('marketing_project', function ($item) {
                return $item->marketing_project ? $item->marketing_project->name : '';
            })
             ->addColumn('sendMessage', function ($item) {

                 if(auth()->user()->can('settings.whatsPercent') && $item->sending_way == 'whatsApp' && $item->whatsapp_template) {
                     return  '<a class="btn-sm btn-outline-primary me-1 waves-effect send_whats" data-id="'.$item->id.'"  href="#" data-url="'. route('whatsPercent', ['id' => $item->id]) .'"><i data-feather="message-circle"></i></a>';
                 }
                 return'';
             })
            ->addColumn('excel', function ($item) {
                if($item->sending_way == 'whatsApp') {

                    return "<a class='btn btn-sm btn-outline-primary me-1 waves-effect' href=".route('whatsAppExcel', ['id' => $item->id]).">
                    <i data-feather='download'></i>
                    </a>";
                }
                return '';
            })
            ->rawColumns([ 'project' ,'category', 'marketing_project','excel','sendMessage' ])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = Compain::distinct()
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
            $data = WhatsappSetting::with('category')->where('category_id', $request->category_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($item) {
                    return $item->category->name ?? '';
                })

                ->rawColumns(['category'])
                ->make(true);
        }
        $item = Category::findOrFail($id);
        return view('admin.pages.compain.whatssapp', get_defined_vars());

    }
    public function savewhatsapp(Request $request)
    {

        $whats = WhatsappSetting::where('category_id', $request->category_id)->first();
        $item = $whats == null ? new WhatsappSetting() : $whats;
        $data = $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);
        $item->status = 0;
        if ($item->save()) {
            flash(__('users.messages.updated'))->success();
        }
        return back();
    }


}

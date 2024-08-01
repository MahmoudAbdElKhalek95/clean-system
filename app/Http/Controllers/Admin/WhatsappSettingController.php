<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsRequest;
use App\Models\Client;
use App\Models\Compain;
use App\Models\Doner;
use App\Models\Link;
use App\Models\Project;
use App\Models\SendedPhone;
use App\Models\SendingTemplate;
use App\Models\WhatsappPhone;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Yajra\DataTables\Facades\DataTables;

class WhatsappSettingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.whatsapps.index', get_defined_vars());
    }

    public function create()
    {
        $phones = WhatsappPhone::all();

        return view('admin.pages.whatsapps.create_edit', get_defined_vars());
    }

    public function edit($id)
    {
        $phones = WhatsappPhone::all();
        $item = WhatsappSetting::findOrFail($id);
        return view('admin.pages.whatsapps.edit', get_defined_vars());
    }

    public function show($id)
    {
        $phones = WhatsappPhone::all();

        $item = WhatsappSetting::findOrFail($id);
        return view('admin.pages.whatsapps.show', get_defined_vars());
    }

    public function destroy($id)
    {

        $item = WhatsappSetting::findOrFail($id);
        if ($item->delete()) {
            flash(__('whatsapps.messages.deleted'))->success();
        }
        return redirect()->route('whatsapps.index');
    }

    public function store(WhatsRequest $request)
    {
        // try {
        $i = 0;
        foreach($request->percent as $percent) {
            $item =  new WhatsappSetting();
            $item->category_id = $request->category_id;
            if($request->type == 'zero') {
                $item->percent = 0;
                $item->percent2 = 0;
            } else {
                $item->percent = $request->percent[$i];
                $item->percent2 = $request->percent2[$i];
            }
            $item->message = $request->message;
            $i++;
            $item->save();
        }
        flash(__('whatsapps.messages.created'))->success();
        // } catch (Exception $e) {
        //     flash(__('whatsapps.messages.error_save'))->error();
        // }
        return redirect()->route('whatsapps.index');
    }

    public function update(Request $request, $id)
    {

        WhatsappSetting::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('whatsapps.messages.updated'))->success();
        }
        return redirect()->route('whatsapps.index');
    }

    protected function processForm($request, $id = null)
    {

        $whats = WhatsappSetting::findOrFail($id);
        $item = $whats == null ? new WhatsappSetting() : $whats;
        $data = $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);

        $item->status = 0;
        if ($item->save()) {
            return $item;
        }
        return null;
    }
    public function getParams($params)
    {

        $pramter_arr  = explode(',', $params);
        $var_arr = [] ;
        foreach($pramter_arr as $key => $item) {
            if($item != "null") {
                $k = $key + 1 ;
                $var_arr["param_$k"] = $item ;
            }
        }
        return $var_arr;
    }
    public function createUrl($var_arr, $project_name = null, $project_code = null, $percecntage = null)
    {
        $url = '';
        foreach ($var_arr as $key => $val) {
            if ($val == "project_name") {
                $url .= '&'.$key.'=' . $project_name;
            }
            if ($val == "project_link") {
                $project_btn = 'https://give.qb.org.sa/P/' . $project_code;

                $url .= '&'.$key.'=' . $project_btn;
            }
            if ($val == "project_percent") {
                $url .= '&'.$key.'=' . $percecntage;
            }
            if ($val == "remain_project_percent") {
                $remain = 100 - $percecntage;
                $url .= '&'.$key.'=' . $remain;
            }
        }
        return $url;
    }
    public function whatsPercent(WhatsappService $whats, $id)
    {
        $i = 0;
        ini_set('max_execution_time', 1048);
        $compain = Compain::findOrFail($id);
        if($compain->whatsapps && $compain->whatsapps) {
            if ($compain->targets == 'client') {
                $phones = Client::whereIn('type_id', json_decode($compain->target_type_id))->groupBy('phone')->pluck('phone')->toArray();
            }
            if ($compain->targets == 'project_donor') {
                $projects_id = json_decode($compain->project_id) ;
                $project_number = Project::whereIn('id', $projects_id)->pluck('code')->toArray();
                $phones = Link::where('project_number', $project_number)->where('project_number','!=',$compain->marketing_project->code)->select('phone')->groupBy('phone')->pluck('phone')->toArray();
            }
            if ($compain->targets == 'donor_type') {
                $phones = Doner::whereIn('doner_type_id', json_decode($compain->target_doner_type_id))->groupBy('phone')->pluck('phone')->toArray();
            }
            $var_arr = $this->getParams($compain->whatsapps->param);
            $image = '';
            $video = '';
            if($compain->whatsapps->image) {
                $image = '&image=' . $compain->whatsapps->image;
            }
            if($compain->whatsapps->videos) {
                $video = '&video=' . $compain->whatsapps->videos;
            }
            $url = '';

            $SendedPhone = SendedPhone::where('project_code', $compain->marketing_project->code)->pluck('phone')->toArray();
            $all_phones = array_diff($phones, $SendedPhone);
            foreach($all_phones as $row) {
                $url = $this->createUrl($var_arr, $compain->marketing_project->name, $compain->marketing_project->code, $compain->marketing_project->getPercent());

                if($compain->whatsapps->button == 'yes') {
                    $url .= "&url_button=".$compain->marketing_project->code ;

                }
                $url .= $image . '' . $video;
                // $whats->sendTemplateMessage("+201159153248", $url, $compain->whatsapps->template_name);
                $whats->sendTemplateMessage(formate_phone_number($row->phone), $url, $compain->whatsapps->template_name);
                $sended_phone = [
                    'project_code' => $compain->marketing_project->code,
                    'percent_id' => $id,
                    'phone' => $row,
                    'status' => 1,
                ];
                SendedPhone::create($sended_phone);
                $i++;
            }

            // $compain->whatsapps->last_send = date('Y-m-d H:i:s');
            // $compain->whatsapps->details = $all_phones;
            // $compain->whatsapps->save();
            flash('تم الارسال بنجاح ل '.$i.' رقم')->success();
        } else {
            flash('يرجى اختيار قالب الارسال اولا')->error();
        }

        return redirect()->route('compain.index');
    }

    public function getRemain(Request $request)
    {
        ini_set('max_execution_time', 1048);
        $compain = Compain::findOrFail($request->id);
        if ($compain->targets == 'client' && $compain->target_type_id) {
            return  Client::whereIn('type_id', json_decode($compain->target_type_id))->groupBy('phone')->count();
        }
        if ($compain->targets == 'project_donor' && $compain->project_id) {
            $projects_id = json_decode($compain->project_id) ;
            $project_number = Project::whereIn('id', $projects_id)->pluck('code')->toArray();
            $phone = Link::where('project_number', $project_number)->where('project_number','!=',$compain->marketing_project->code)->groupBy('phone')->select('phone')->get();
            return count($phone);
        }
        if ($compain->targets == 'donor_type' && $compain->target_doner_type_id) {
            return Doner::whereIn('doner_type_id', json_decode($compain->target_doner_type_id))->groupBy('phone')->count();
        }
        return 0;
    }
    public function getRemainAjax(Request $request)
    {
        ini_set('max_execution_time', 1048);
        $phones_count = 0;
        if ($request->targets == 'client' && $request->project_id) {
            $phones_count=  Client::whereIn('type_id', $request->project_id)->groupBy('phone')->count();
        }
        if ($request->targets == 'project_donor' && $request->project_id) {
            $project_number = Project::whereIn('id', $request->project_id)->pluck('code')->toArray();
            $phone = Link::where('project_number', $project_number)->groupBy('phone')->select('phone')->get();
            $phones_count= count($phone);
        }
        if ($request->targets == 'donor_type' && $request->project_id) {
            $phones_count= Doner::whereIn('doner_type_id', $request->project_id)->groupBy('phone')->count();
        }
        return ' سيتم الارسالى الى '.$phones_count.' رقم';
    }
    public function list(Request $request)
    {

        $data = WhatsappSetting::with(['category','sendingTemplate'])->select('whatsapp_settings.*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category->name ?? '';
            })
             ->addColumn('sendMessage', function ($item) {
                 $data['remain_phones'] = 0;
                 $data['send_button'] = '';
                 $data['sended_phones'] = 0;
                 if(auth()->user()->can('settings.whatsPercent')) {
                     $data['send_button'] = '<a class="btn-sm btn-outline-primary me-1 waves-effect send_whats" data-id="'.$item->id.'" data-percent="'.$item->percent.'" data-category_id="'.$item->category_id.'" data-percent2="'.$item->percent2.'" data-type="'.$item->type.'" href="#" data-url="'. route('whatsPercent', ['id' => $item->id]) .'"><i data-feather="message-circle"></i></a>';
                 }
                 return  json_encode($data);
             })
            ->editColumn('message', function ($item) {
                return $item->sendingTemplate->template_name ?? '';
            })
            ->rawColumns(['category','message','sendMessage'])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = WhatsappSetting::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })
             ->select('id', 'name AS text')
             ->get();
        return response()->json($data);
    }

    public function select2(Request $request)
    {

        $data = WhatsappSetting::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('message', 'LIKE', '%' . $request->q . '%');
                 }
             }) ->select('id', 'message AS text ')
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
        $item = WhatsappSetting::findOrFail($id);
        return view('admin.pages.whatsapps.whatssapp', get_defined_vars());
    }
    public function savewhatsapp(Request $request)
    {
        return back();
    }



    public function whatsAppExcel($id, Request $request)
    {
        if($id == null) {
            $id = request('id');
        }


        $compain = Compain::findOrFail($id);
        if ($compain->sending_way == 'whatsApp') {
            $sending_template = SendingTemplate::find($compain->whatsapp_template);

            $phones = [];
            $var_arr = [];
            $parms_arr = [];
            $project_name = '';
            $project_code = '';
            $percent = 0;
            $project = Project::find($compain->marketing_project_id);
            if($sending_template && $project) {
                $var_arr = $this->getParams($sending_template->param);

                foreach($var_arr as  $key => $value) {
                    array_push($parms_arr, $value) ;
                }


                if(in_array('project_name', $parms_arr)) {
                    $project_name = $project->name;
                }

                if(in_array('project_link', $parms_arr)) {
                    $project_code = 'https://give.qb.org.sa/P/' . $project->code ;
                }
                if(in_array('project_percent', $parms_arr)) {
                    if($project->totalSalesTarget > 0) {
                        $percent = ($project->totalSalesDone  /  $project->totalSalesTarget)  ;
                    }
                }
            }
            if ($compain->targets == 'client' && $compain->target_type_id) {
                $phones = Client::whereIn('type_id', json_decode($compain->target_type_id))->pluck('phone')->toArray();

            }
            if ($compain->targets == 'project_donor' && $compain->project_id) {
                $projects_id = json_decode($compain->project_id) ;


                $project_number = Project::whereIn('id', $projects_id)->pluck('code')->toArray();
                $phones = Link::where('project_number', $project_number)->select('phone')->groupBy('phone')->pluck('phone')->toArray();

            }
            if ($compain->targets == 'donor_type' && $compain->target_doner_type_id) {
                $phones = Doner::whereIn('doner_type_id', json_decode($compain->target_doner_type_id))->pluck('phone')->toArray();
            }

            $pramaters       = implode('---', $parms_arr) ;
            $template_name   = $sending_template->template_name ?? null   ;

            $new_arr = [] ;

            foreach($phones as $phone) {
                array_push($new_arr, [
                    'phone' => "966".$phone ,
                    'pramaters' => $pramaters ,
                    'template_name' => $template_name ,
                    'projects_names'  =>   $project_name,
                    'project_links'  =>   $project_code ,
                    'project_percents'  =>  $percent,
                    'remain_project_percents'  =>  (100 - $percent) > 0 ?? 0
                ]) ;
            }

            return FastExcel::data($new_arr)->download('whatsapp.xlsx', function ($item) {
                return [
                      'ارقام الجوال' => $item['phone'],
                     //'المتغيرات'  => $item['pramaters'],
                     'اسم القالب'  => $item['template_name'],
                     'اسم المشروع '  => $item['projects_names'],
                     'رابط المشروع '  => $item['project_links'],
                     'نسبة المشروع '  => $item['project_percents'],
                     'النسبة المتبقية '  => $item['remain_project_percents'],


                ];
            });

        }
        // return '';
    }



}

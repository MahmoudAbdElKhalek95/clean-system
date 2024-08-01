<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Carbon\Carbon;
use App\Models\Link;
use App\Models\Target;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectMessage;
use App\Services\WhatsappService;
use DateTime;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $archive=Archive::where('status', 1)->first();
        $data['archive']=$archive;
        if($archive) {
            $archive_id=$archive->id;
        } else {
            $archive_id=0;
        }
        $data['total_shop_donations']  = Link::where('oprtation_type', 1)
           ->where('date', date('Y-m-d'))
           ->where('archive_id', $archive_id)
           ->sum('total');

        $max_shop_donations_arr  = Link::where('oprtation_type', 1)
              ->where('date', date('Y-m-d'))
              ->where('archive_id', $archive_id)
              ->pluck('total')
              ->toArray();

        if(!empty($max_shop_donations_arr) && count($max_shop_donations_arr) > 0) {
            $data['max_shop_donations']  = max($max_shop_donations_arr);
        } else {
            $data['max_shop_donations']  = 0;
        }
        $data['total_prices']  = Link::where('archive_id', $archive_id)->sum('total');
        $total_percent =  (($data['total_prices'])/($archive->amount??1))*100;
        $data['total_percent'] = number_format($total_percent, 2);
        return view('statistics', $data);
    }

    public function indexApi()
    {
        $archive=Archive::where('status', 1)->first();
        $data['archive']=$archive;
        if($archive) {
            $archive_id=$archive->id;
        } else {
            $archive_id=0;
        }
        $data['total_shop_donations']  = Link::where('oprtation_type', 1)
        ->where('date', date('Y-m-d'))->sum('total');
        $max_shop_donations_arr  = Link::where('archive_id', $archive_id)->where('oprtation_type', 1)
        ->where('date', date('Y-m-d'))->pluck('total')->toArray();
        $max_shop_donations_arr = array_unique($max_shop_donations_arr);
        $data['max_shop_donations'] = count($max_shop_donations_arr) ? max($max_shop_donations_arr) : 0 ;
        $data['total_prices'] =Link::where('archive_id', $archive_id)->sum('total');
        $total_percent = (($data['total_prices'])/($archive->amount??1))*100;
        $data['total_percent'] = number_format($total_percent, 2);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function target_statistics(Request $request)
    {
        $archive=Archive::where('status', 1)->first();
        $data['archive'] = $archive;
        if($archive) {
            $archive_id=$archive->id;
        } else {
            $archive_id=0;
        }
        $data['total_shop_donations']  = Link::where('archive_id', $archive_id)
        ->where('oprtation_type', 1)
        ->where('date', date('Y-m-d'))->sum('total');

        $max_shop_donations_arr  = Link::where('oprtation_type', 1)
        ->where('archive_id', $archive_id)
        ->where('date', date('Y-m-d'))
        ->pluck('total')
        ->toArray();

        if(!empty($max_shop_donations_arr) && count($max_shop_donations_arr) > 0) {
            $data['max_shop_donations']  = max($max_shop_donations_arr);
        } else {
            $data['max_shop_donations']  = 0;
        }

        $data['total_prices']  = Link::where('archive_id', $archive_id)->sum('total');
        $total_percent =  (($data['total_prices'])  / ($archive->amount??1)) * 100;
        $data['total_percent'] = number_format($total_percent, 2);
        if(request()->filled('type')) {
            $type = request('type');
        } else {
            $type = 1;
        }
        $targets = Target::where('type', $type)
            ->where('show_in_statistics', 1)
            ->groupBy('targets.section_id')
            ->select([
            'targets.section_id',
                DB::raw('sum(target) as all_targets'),
            ])->get();
        $map = $targets->map(function ($item) use ($type, $archive_id) {
            return [
                'name'              => $item->getNmae($type),
                'total_targets'     => number_format($item->all_targets),
                'total_achieved'    => number_format($item->total_achieved($type, $archive_id))
            ];
        });
        $data['map'] = $map;
        return view('target_statistics', $data);
    }

    public function new_target_statistics(Request $request)
    {
        $archive=Archive::where('status', 1)->first();
        $data['archive'] = $archive;
        $archive_id = $archive->id ?? null;
        $data['total_shop_donations']  = Link::where('oprtation_type', 1)
            ->where('archive_id', $archive_id)
            ->where('date', date('Y-m-d'))->sum('total');
        $max_shop_donations_arr  = Link::where('oprtation_type', 1)
        ->where('archive_id', $archive_id)
        ->where('date', date('Y-m-d'))
        ->pluck('total')
        ->toArray();
        if(!empty($max_shop_donations_arr) && count($max_shop_donations_arr) > 0) {
            $data['max_shop_donations']  = max($max_shop_donations_arr);
        } else {
            $data['max_shop_donations']  = 0 ;
        }
        $data['total_prices']  = Link::where('archive_id', $archive_id)->sum('total');
        $total_percent =  (($data['total_prices'])  / ($archive->amount??1)) * 100;
        $data['total_percent'] = number_format($total_percent, 2);
        if(request()->filled('type')) {
            $type = request('type');
        } else {
            $type = 1;
        }
        $targets = Target::where('type', $type)
        ->where('show_in_statistics', 1)
        ->groupBy('targets.section_id')
        ->select([
            'targets.section_id',
                DB::raw('sum(target) as all_targets'),
            ])->get();
        $map = $targets->map(function ($item) use ($type) {
            return [
                'name'              => $item->getNmae($type),
                'total_targets'     => number_format($item->all_targets),
                'total_achieved'    => number_format($item->total_achieved($type))
            ];
        });

        $data['map'] = $map ;
        $t=time();
        $time_now = date("H:i", $t)  ;
        $hour_number =  explode(':', $time_now)[0] * 60 ;
        $minute_number =  explode(':', $time_now)[1] ;
        $secound_number =   $hour_number + $minute_number   ;
        $yesterday =  date("Y-m-d", strtotime("yesterday"));
        $data['total_yesterday']  = Link::where('archive_id', $archive_id)
        ->where('oprtation_type', 1)
        ->where('date', $yesterday)
        ->sum('total');
        $data['total_yesterday_for_secounds']  =   $data['total_yesterday']  / (24*60);
        $data['total_yesterday_at_moment']  = Link::where('archive_id', $archive_id)
        ->where('oprtation_type', 1)
        ->where('date', $yesterday)
        ->whereTime('created_at', '<=', Carbon::parse($time_now)->toTimeString())
        ->sum('total');
        if($secound_number > 0) {
            $data['total_for_secounds']  =   $data['total_shop_donations']  / ($secound_number);
        } else {
            $data['total_for_secounds']  = 0  ;
        }
        $data['expected_close']  =   $data['total_for_secounds']   * 1441 ;
        if(request()->filled('category_id')) {
            $data['all_percent'] =  get_statistics_percent(request('category_id'));
        } else {
            $data['all_percent'] =  []  ;
        }
        return view('new_target_statistics', $data);
    }

    public function getProjectCount()
    {
        $archive=Archive::where('status', 1)->first();
        if($archive) {
            $archive_id=$archive->id;
        } else {
            $archive_id=0;
        }
        $total_projects = DB::table('views_project_calculates')->where('archive',$archive_id)->count();
        $total_done = DB::table('views_project_calculates')->where('archive',$archive_id)->sum('total_done');
        $target = DB::table('views_project_calculates')->where('archive',$archive_id)->sum('target');
        $total_messages = DB::table('project_messages')->count();
        $total_messages += DB::table('project_reminders')->count();
        $data = ['total_projects' => number_format($total_projects), 'total_collected' => number_format($total_done), 'total_amount' => number_format($target),'total_messages'=>number_format($total_messages)];
        return apiResponse(true, $data, null, null, 200);
    }

    public function getTotalAfterMessage()
    {
        $data = ProjectMessage::with('project')->get();
        $result = 0;
        foreach($data as $item) {
            if ($item->project) {
                $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                if ($next_message) {
                    $total = $item->archieved + Link::where('project_number', $item->project->code)->whereBetween('created_at', [$item->created_at, $next_message->created_at])->sum('total');
                } else {
                    $total = $item->archieved + Link::where('project_number', $item->project->code)->whereDate('created_at', '>', $item->created_at)->sum('total');
                }
                if ($item->archieved) {
                    $result +=($total - $item->archieved);
                } else {
                    $item_archieved = Link::where('project_number', $item->project->code)->whereDate('created_at', '<', $item->created_at)->sum('total');
                    $result +=($total - $item_archieved);
                }
            }
        }
        return apiResponse(true, number_format($result), null, null, 200);
    }

    public function getProjectStatistics(Request $request)
    {
        // return apiResponse(true, $request->all(), null, null, 200);
        $data = Project::with('category')
        ->where(function($query) use ($request) {
            $query->where('category_id', $request->category_id);
            // if ($request->filled('category_id') && !empty($request->filled('category_id'))) {
            // }
            if ($request->filled('project_id') && !empty($request->filled('project_id'))) {
                $query->where('id', $request->project_id);
            }

        })
        ->get();
        $collected_10 = 0;
        $projects_10 = 0;
        $total_10 = 0;

        $collected_20 = 0;
        $projects_20 = 0;
        $total_20 = 0;

        $collected_30 = 0;
        $projects_30 = 0;
        $total_30 = 0;

        $collected_40 = 0;
        $projects_40 = 0;
        $total_40 = 0;

        $collected_50 = 0;
        $projects_50 = 0;
        $total_50 = 0;

        $collected_60 = 0;
        $projects_60 = 0;
        $total_60 = 0;

        $collected_70 = 0;
        $projects_70 = 0;
        $total_70 = 0;

        $collected_80 = 0;
        $projects_80 = 0;
        $total_80 = 0;

        $collected_90 = 0;
        $projects_90 = 0;
        $total_90 = 0;

        $collected_100 = 0;
        $projects_100 = 0;
        $total_100 = 0;

        $monday = strtotime('next Monday -1 week');
        $monday = date('w', $monday) == date('w') ? strtotime(date("Y-m-d", $monday) . " +7 days") : $monday;
        $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
        $this_week_sd = date("Y-m-d", $monday);
        $this_week_ed = date("Y-m-d", $sunday);

        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $start_week = date("Y-m-d", $start_week);


        foreach($data as $project) {
            $total_collected = Link::where(function($query) use($request,$this_week_sd,$this_week_ed,$start_week) {
                if ($request->filled('filter_date') && !empty($request->filled('filter_date'))) {
                    switch($request->filter_date) {
                        case 1:
                            {
                                $query->where('date', date('Y-m-d'));
                                $query->orWhere('date', date('d-m-Y',strtotime("-1 days")));
                            }
                            case 2:{
                                $query->where('date','>=', $this_week_sd);
                                $query->where('date','<=', $this_week_ed);
                            }
                            case 3:{
                                $query->where('date','>=', $start_week);
                                $query->where('date','<=', $this_week_ed);
                            }
                            case 4:{
                                $first_day_this_month = date('m-01-Y');
                                $last_day_this_month  = date('m-t-Y');
                                $query->where('date','>=', $first_day_this_month);
                                $query->where('date','<=', $last_day_this_month);
                            }
                            case 5: {
                                $year = date('Y');
                                $query->where('date','>=', $year.'-01-01');
                                $query->where('date','<=', $year.'12-31');
                            }
                    }
                }
            })
            ->where('project_number', $project->code)->sum('total');
            $target = $project->price * $project->quantityInStock;
            if ($target > 0) {
                $percent = ($total_collected / $target) * 100 ;
                if($percent <= 10) {
                    $projects_10++;
                    $collected_10 +=$total_collected;
                    $total_10 +=$target;
                }
                if($percent <= 20  && $percent > 10) {
                    $projects_20++;
                    $collected_20 +=$total_collected;
                    $total_20 +=$target;
                }
                if($percent <= 30 && $percent > 20) {
                    $projects_30++;
                    $collected_30 +=$total_collected;
                    $total_30 +=$target;
                }
                if($percent <= 30) {
                    $projects_40++;
                    $collected_40 +=$total_collected;
                    $total_40 +=$target;
                }
                if($percent <= 50  && $percent > 40) {
                    $projects_50++;
                    $collected_50 +=$total_collected;
                    $total_50 +=$target;
                }
                if($percent <= 60  && $percent > 50) {
                    $projects_60++;
                    $collected_60 +=$total_collected;
                    $total_60 +=$target;
                }
                if($percent <= 70  && $percent > 60) {
                    $projects_70++;
                    $collected_70 +=$total_collected;
                    $total_70 +=$target;
                }
                if($percent <= 80  && $percent > 70) {
                    $projects_80++;
                    $collected_80 +=$total_collected;
                    $total_80 +=$target;
                }
                if($percent <= 90 && $percent > 80) {
                    $projects_90++;
                    $collected_90 +=$total_collected;
                    $total_90 +=$target;
                }
                if($percent <= 100 && $percent > 90) {
                    $projects_100++;
                    $collected_100 +=$total_collected;
                    $total_100 +=$target;
                }
            }
        }
        $html_10 ='<p>'.__('admin.project_number').' - ';
        $html_10 .=$projects_10.'</p>';
        $html_10 .='<p>'.__('admin.total_done').' - ';
        $html_10 .=$collected_10.'</p>';
        $html_10 .='<p>'.__('admin.total_price').' - ';
        $html_10 .=$total_10.'</p>';

        $html_20 ='<p>'.__('admin.project_number').' - ';
        $html_20 .=$projects_20.'</p>';
        $html_20 .='<p>'.__('admin.total_done').' - ';
        $html_20 .=$collected_20.'</p>';
        $html_20 .='<p>'.__('admin.total_price').' - ';
        $html_20 .=$total_20.'</p>';

        $html_30 ='<p>'.__('admin.project_number').' - ';
        $html_30 .=$projects_30.'</p>';
        $html_30 .='<p>'.__('admin.total_done').' - ';
        $html_30 .=$collected_30.'</p>';
        $html_30 .='<p>'.__('admin.total_price').' - ';
        $html_30 .=$total_30.'</p>';

        $html_40 ='<p>'.__('admin.project_number').' - ';
        $html_40 .=$projects_40.'</p>';
        $html_40 .='<p>'.__('admin.total_done').' - ';
        $html_40 .=$collected_40.'</p>';
        $html_40 .='<p>'.__('admin.total_price').' - ';
        $html_40 .=$total_40.'</p>';

        $html_50 ='<p>'.__('admin.project_number').' - ';
        $html_50 .=$projects_50.'</p>';
        $html_50 .='<p>'.__('admin.total_done').' - ';
        $html_50 .=$collected_50.'</p>';
        $html_50 .='<p>'.__('admin.total_price').' - ';
        $html_50 .=$total_50.'</p>';

        $html_60 ='<p>'.__('admin.project_number').' - ';
        $html_60 .=$projects_60.'</p>';
        $html_60 .='<p>'.__('admin.total_done').' - ';
        $html_60 .=$collected_60.'</p>';
        $html_60 .='<p>'.__('admin.total_price').' - ';
        $html_60 .=$total_60.'</p>';

        $html_70 ='<p>'.__('admin.project_number').' - ';
        $html_70 .=$projects_70.'</p>';
        $html_70 .='<p>'.__('admin.total_done').' - ';
        $html_70 .=$collected_70.'</p>';
        $html_70 .='<p>'.__('admin.total_price').' - ';
        $html_70 .=$total_70.'</p>';

        $html_80 ='<p>'.__('admin.project_number').' - ';
        $html_80 .=$projects_80.'</p>';
        $html_80 .='<p>'.__('admin.total_done').' - ';
        $html_80 .=$collected_80.'</p>';
        $html_80 .='<p>'.__('admin.total_price').' - ';
        $html_80 .=$total_80.'</p>';

        $html_90 ='<p>'.__('admin.project_number').' - ';
        $html_90 .=$projects_90.'</p>';
        $html_90 .='<p>'.__('admin.total_done').' - ';
        $html_90 .=$collected_90.'</p>';
        $html_90 .='<p>'.__('admin.total_price').' - ';
        $html_90 .=$total_90.'</p>';

        $html_100 ='<p>'.__('admin.project_number').' - ';
        $html_100 .=$projects_100.'</p>';
        $html_100 .='<p>'.__('admin.total_done').' - ';
        $html_100 .=$collected_100.'</p>';
        $html_100 .='<p>'.__('admin.total_price').' - ';
        $html_100 .=$total_100.'</p>';

        $data=[
           'data_10'=>$html_10,
           'data_20'=>$html_20,
           'data_30'=>$html_30,
           'data_40'=>$html_40,
           'data_50'=>$html_50,
           'data_60'=>$html_60,
           'data_70'=>$html_70,
           'data_80'=>$html_80,
           'data_90'=>$html_90,
           'data_100'=>$html_100
        ];
        return apiResponse(true, $data, null, null, 200);

    }

    public function categoryStatistic()
    {
        // [11,12,13,19,20]
    }

    public function getActivePages(Request $request)
    {

        // $client = new Google_Client();
        // $client->setApplicationName("Statistics");
        // $client->setAuthConfig(SERVICE_ACCOUNT);
        // $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        // $analytics = new \Google_Service_Analytics($client);
        // if(isset($_GET['action'])){
        //     $action = $_GET['action'];
        //     if($action=='pages'){
        //         $optParams = array(
        //             'dimensions' => 'rt:pageTitle,rt:pagePath',
        //             'sort' => '-rt:activeVisitors',
        //             'max-results' => '5'
        //      );
        //         $result = $analytics
        //         ->data_realtime
        //         ->get('ga:'.VIEW, 'rt:activeVisitors',$optParams);
        //         return $result;

        //     if($result){
        //         $rows = $result->getRows();
        //         return view('pages', ['rows' => $rows,'result'=>$result]);
        //         }else{
        //         return view('pages', ['rows' => [],'result'=>false]);
        //     }
        // }
        // elseif($action=='users'){
        //         $active_users = $analytics
        //                 ->data_realtime
        //                 ->get('ga:'.VIEW, 'rt:activeVisitors');
        //         $active_users = (isset($active_users->rows[0][0]))?$active_users->rows[0][0]:0;
        //         return $active_users;
        //     }
        // }

    }

    public function wirte_image(WhatsappService $whats)
    {
        $project = Project::first();
        return wirte_text_image(arabic_utf8($project->name));
        // $project_link = "https://give.qb.org.sa/P/" . $project->code;
        // $whats->whatsTemplate("+201159153248", "project test",$project_link);
        // sleep(1);
        // $whats->whatsTemplate("+966555138539", "project test",$project_link);
        // return 'Success';
        // $categories = Category::whereIn('id',[14,12,21,18,19])->get();
        // $data = [];
        // foreach($categories as $category){
        //     $data[$category->name]=Link::whereIn('project_number', $category->projects->pluck('code'))->groupBy('phone')->pluck('phone')->toArray();
        // }
        // dd($data);
        //   return "Asd" ;

    }

    public function checkWhatsapp()
    {

        $code = 2608;
        $whats=new WhatsappService();
        $project = Project::leftJoin('links', 'projects.code', 'links.project_number')
                    ->where('projects.code', $code)
                        ->groupBy('projects.id')
                    ->select([
                        'projects.code as code',
                        'projects.id',
                        'projects.name',
                        'projects.category_id',
                        DB::raw('sum(links.total) as total_done'),
                        'projects.price',
                        'projects.quantityInStock'
                    ])->first();
        if ($project) {
            $target = $project->price * $project->quantityInStock;
            if ($target == 0) {
                return;
            }
            $user_phones = Link::where('project_number', $project->code)->pluck('phone')->toArray();
            if (count($user_phones) == 0) {
                return;
            }
            if ((($project->total_done / $target) * 100) >= 100) {
                foreach ($user_phones as $phone) {
                    $image = wirte_text_image(arabic_utf8($project->name));
                    $whats->sendImage("+201159153248", $image);
                    sleep(2);
                }
                // $project->message = 1;
                // $project->save();
            }
        }


    }

}

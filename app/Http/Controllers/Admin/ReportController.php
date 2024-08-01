<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use App\Models\ClientUser;
use Illuminate\Http\Request;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\DonerType;
use DateInterval;
use DatePeriod;
use DateTime;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.report.index', get_defined_vars());
    }


    public function list(Request $request)
    {
        $diffDate=[];

        $data = Link::where(function ($query) use ($request) {
            if ($request->filled('from') && $request->filled('to')) {
                $query->where('operation_time', '>=', $request->from)
                    ->where('operation_time', '<=', $request->to);
            }
            if ($request->filled('category_id') && !empty($request->filled('category_id'))) {
                $query->whereIn('category_id', $request->category_id);
            }
            if ($request->filled('project_id') && !empty($request->filled('project_id'))) {
                $query->where('project_number', $request->project_id);
            }
        });

        if($request->filled('datef') && $request->filled('datet')&& !empty($request->datet)&& !empty($request->datef)) {

            $dateRangef = explode(" to ", $request->datef);
            $dateRanget = explode(" to ", $request->datet);
            if ((count($dateRangef) > 1) && (count($dateRanget) > 0)) {
                $startDatef = Carbon::createFromFormat("Y-m-d", $dateRangef[0])->format('Y-m-d');
                $endtDatef = Carbon::createFromFormat("Y-m-d", $dateRangef[1])->format('Y-m-d');

                $startDatet = Carbon::createFromFormat("Y-m-d", $dateRanget[0])->format('Y-m-d');
                $endtDatet = Carbon::createFromFormat("Y-m-d", $dateRanget[1])->format('Y-m-d');
                $row1 = $data->where('date', '>=', $startDatef)
                    ->where('date', '<=', $endtDatef)
                    ->select([
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ])->first();
                $row2 = $data->where('date', '>=', $startDatet)
                    ->where('date', '<=', $endtDatet)
                    ->select([
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ])->first();
                $data = [$row1,$row2];
                $diffDate=$data;
            }elseif ($request->filled('filter_date') && !empty($request->filter_date)) {
            if($request->filter_date == 'week') {
                $data->groupBy(DB::raw('Week(date,0)'), DB::raw('Year(date)'))
                    ->select([
                        DB::raw('WEEK(date,0) as filterDate'),
                        DB::raw('Year(date) as year'),
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ]);
            } elseif($request->filter_date == 'month') {
                $data->groupBy(DB::raw('Month(date)'), DB::raw('Year(date)'))
                    ->select([
                        DB::raw('Month(date) as filterDate'),
                        DB::raw('Year(date) as year'),
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ]);
            } elseif($request->filter_date == 'year') {
                $data->groupBy(DB::raw('Year(date)'))
                    ->select([
                        DB::raw('Year(date) as filterDate'),
                        DB::raw('Year(date) as year'),
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ]);
            } else {
                $data->groupBy('date')
                    ->select([
                        DB::raw('date as filterDate'),
                        DB::raw('Year(date) as year'),
                        DB::raw('sum(total) as total'),
                        DB::raw('count(*) as count')
                    ]);
            }
        }  else {
                $data->groupBy('date')
                        ->select([
                            DB::raw('date as filterDate'),
                            DB::raw('Year(date) as year'),
                            DB::raw('sum(total) as total'),
                            DB::raw('count(*) as count')
                    ]);
            }
        } else {
            $data->groupBy('date')
                ->select([
                    DB::raw('date as filterDate'),
                    DB::raw('Year(date) as year'),
                    DB::raw('sum(total) as total'),
                    DB::raw('count(*) as count')
            ]);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('diffrence', function ($item) use ($request,$diffDate) {

                if (request()->filled('datef') && request()->filled('datet') && !empty(request()->datet) && !empty(request()->datef)) {
                    $count = ($diffDate[1]->total - $diffDate[0]->total);
                    $count = ['count1' => round($diffDate[0]->count, 2),'count2' => round($count, 2)];
                    return json_encode($count);
                }

                if (request()->filled('from') && request()->filled('to')) {
                    $from = Carbon::parse(request('from'))->toTimeString();
                    $to = Carbon::parse(request('to'))->toTimeString();
                } else {
                    $from = null;
                    $to = null;
                }
                return $item->today_yesterday_percent($item->filterDate, $from, $to, $request->filter_date, $item->year);
            })->addColumn('percent', function ($item) use ($request,$diffDate) {
                if (request()->filled('datef') && request()->filled('datet') && !empty(request()->datet) && !empty(request()->datef)) {
                    if($diffDate[0]->total>0){
                        $percent = ($diffDate[1]->total / $diffDate[0]->total) * 100;
                    }else{
                        $percent = ($diffDate[1]->total) * 100;
                    }
                    $percent=['percent1'=>round($diffDate[0]->total,2),'percent2'=>round($percent,2)];
                return json_encode($percent);
                }
                if (request()->filled('from') && request()->filled('to')) {
                    $from = Carbon::parse(request('from'))->toTimeString();
                    $to = Carbon::parse(request('to'))->toTimeString();
                } else {
                    $from = null;
                    $to = null;
                }
                $percent = $item->today_yesterday_percent($item->filterDate, $from, $to, $request->filter_date, $item->year, 1);
                $percent = round($percent, 2);
                if ($percent >= 100) {
                    return '<button class="btn btn-sm btn-outline-success me-1 waves-effect">
                   ' . ($percent - 100) . '%</button>';

                } else {

                    return '<button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                   ' . (100 - $percent) . '%</button>';
                }
            })->editColumn('date', function ($item) {
                if(request()->filled('datef') && request()->filled('datet')&& !empty(request()->datet)&& !empty(request()->datef)) {
                    return '';
                } elseif (request()->filled('filter_date') && request()->filter_date == 'month') {
                    return $item->filterDate . '-' . $item->year;
                }
                return $item->filterDate;
            })
            ->rawColumns(['percent','date','diffrence'])
            ->make(true);
    }

    public function getStartAndEndDate($week, $year)
    {
        //Below gives week from mon to sun
        $weeks = [];
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        for($i = 0;$i <= 5;$i++) {
            $weeks[$i]['start'] = $dto->format('Y-m-d');
            $dto->modify('+6 days');
            $weeks[$i]['end'] = $dto->format('Y-m-d');
            $dto->modify('-13 days');
        }
        return array_reverse($weeks);
    }

    public function donersReport(Request $request)
    {
        $data = [];
        $donnerTypes = DonerType::all();
        $total = Link::sum('total');
        foreach ($donnerTypes as $donnerType) {
            $repeatData = DB::select('
                    SELECT count(phone) AS phone,SUM(totalLinks) AS totalOperations,SUM(total) total from (SELECT phone, COUNT(*) AS totalLinks, SUM(total) AS total
                    FROM `links`
                    GROUP BY `phone`
                    HAVING SUM(total)>=' . $donnerType->from . ' AND SUM(total)<=' . $donnerType->to . ' AND COUNT(phone)>1) AS t');
            $singleData = DB::select('
                    SELECT count(phone) AS phone,SUM(totalLinks) AS totalOperations,SUM(total) total from (SELECT phone, COUNT(*) AS totalLinks, SUM(total) AS total
                    FROM `links`
                    GROUP BY `phone`
                    HAVING SUM(total)>=' . $donnerType->from . ' AND SUM(total)<=' . $donnerType->to . ' AND COUNT(phone)=1) AS t');
            $obj = new \stdClass();
            $obj->name = $donnerType->name;
            $obj->donner_number = $repeatData[0]->phone + $singleData[0]->phone;
            $obj->single_price = $singleData[0]->total;
            $obj->repeat_price = $repeatData[0]->total;
            $obj->single_number = $singleData[0]->phone;
            $obj->repeat_number = $repeatData[0]->phone;
            $obj->operation_number = $singleData[0]->totalOperations + $repeatData[0]->totalOperations;
            $data[] = $obj;
        }
        return view('admin.pages.reports.donners', ['data' => $data,'total' => $total]);
    }

    public function project_donors_report(Request $request)
    {

        if($request->ajax()) {
            $data =
            DB::table('view_project_doners')
            ->whereNotNull('view_project_doners.phone')
            ->where('view_project_doners.project_number', $request->project_id)
            ->groupBy('view_project_doners.phone')
            ->select([DB::raw('sum(total) as total'),DB::raw('sum(number_of_operations) as number_of_operations'),'view_project_doners.phone as phone']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('data_total', function ($item) {
                    $q = DB::select('
                    SELECT total,date FROM links WHERE phone="' . $item->phone . '" and project_number=' . request()->project_id . ' ORDER BY id DESC LIMIT 1');

                    $data['total'] = 0;
                    $data['date'] = '';
                    if(count($q) > 0) {
                        $data['total'] = $q[0]->total;
                        $data['date'] = $q[0]->date;
                    }

                    return json_encode($data);
                })
                ->addColumn('other_project_count', function ($item) use ($request) {
                    $q = DB::select('
                    SELECT sum(total) as other_total,count(phone) as other_operations,phone FROM links WHERE phone="' . $item->phone . '" and project_number != ' . request()->project_id . ' group by phone  LIMIT 1');
                    $other_total = 0;
                    $other_operations = 0;
                    if(count($q) > 0) {
                        $other_total = $q[0]->other_total;
                        $other_operations = $q[0]->other_operations;
                    }
                    $total = $item->total + $other_total;
                    $doner_type = getDonerType($total);
                    return json_encode(['other_total' => $other_total,'other_operations' => $other_operations,'doner_type' => $doner_type]);
                })
            ->rawColumns([ 'data_total','other_project_count'])
            ->make(true);
        }

        return view('admin.pages.reports.project_donors_report');
    }


}

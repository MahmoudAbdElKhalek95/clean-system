<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Link;
use App\Models\Path;
use App\Models\ProjectMessage;
use App\Models\Target;
use App\Models\User;
use App\Models\ClientUser;
use App\Models\Initiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ShareLink;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    private $viewIndex  = 'admin.pages.dashboard.index';

    public function index(Request $request)
    {
        $usersids = [];
        $userscodes = [];
        if (session()->has('responsiveId')) {
            $usersids = ClientUser::where('user_id', session('responsiveId'))->pluck('client_id')->toArray();
            $userscodes = User::whereIn('id', $usersids)->pluck('code')->toArray();
        }
        if(auth()->user()->type == User::TYPE_ADMIN) {
            $total_payments = Link::where(function ($query) use ($usersids, $userscodes) {
                if (session()->has('responsiveId')) {
                    $query->whereIn('user_id', $usersids)
                        ->orWhere(function ($q) use ($userscodes) {
                            $q->whereIn('code', $userscodes);
                        });
                }
                if (auth()->user()->type == User::TYPE_CLIENT) {
                    $query->where('user_id', auth()->user()->id);
                    $query->orWhere('code', auth()->user()->id);
                }
            })->where(function ($query) {
                if (session('activeArchive')!=0) {
                    $query->where('archive_id', session('activeArchive'));
                }
            })->sum(DB::raw('total'));
        } else {
            $total_payments = Link::where(function ($query) use ($usersids, $userscodes) {
                if (session()->has('responsiveId')) {
                    $query->whereIn('user_id', $usersids)
                        ->orWhere(function ($q) use ($userscodes) {
                            $q->whereIn('code', $userscodes);
                        });
                }
                if (auth()->user()->type == User::TYPE_CLIENT) {
                    $query->where('user_id', auth()->user()->id);
                    $query->orWhere('code', auth()->user()->id);
                }
            })->where(function ($query) {
                if (session('activeArchive')!=0) {
                    $query->where('archive_id', session('activeArchive'));
                }
            })->sum(DB::raw('total'));

        }
        $data['total_payments'] = $total_payments;
        $data['progress_total_payments'] = [];


        $percent = round(($total_payments / 3900) * 100, 2);
        // if($percent>100){
        //     $data['progress_total_payments'][]=100;
        //     while($percent>100){
        //         $percent=$percent-100;
        //         if($percent>100){
        //             $data['progress_total_payments'][] =100;
        //         }else{
        //             $data['progress_total_payments'][] =$percent;
        //         }
        //     }
        // }else{

        // }
        $data['progress_total_payments'][] = $percent;

        $data['total_day'] = Link::where(function ($query) use ($usersids, $userscodes) {
            if (session()->has('responsiveId')) {
                $query->whereIn('user_id', $usersids)
                    ->orWhere(function ($q) use ($userscodes) {
                        $q->whereIn('code', $userscodes);
                    });
            }
            if (auth()->user()->type == User::TYPE_CLIENT) {
                $query->where('user_id', auth()->user()->id);
                $query->orWhere('code', auth()->user()->id);
            }
        })->where(function ($query) {
                if (session('activeArchive')!=0) {
                    $query->where('archive_id', session('activeArchive'));
                }
            })
        ->whereDate('date', date('Y-m-d'))
        ->sum(DB::raw('amount * price'));

        $data['totla_methods']  = Link::where(function ($query) use ($usersids, $userscodes) {
            if (session()->has('responsiveId')) {
                $query->whereIn('user_id', $usersids)
                    ->orWhere(function ($q) use ($userscodes) {
                        $q->whereIn('code', $userscodes);
                    });
            }
            if (auth()->user()->type == User::TYPE_CLIENT) {
                $query->where('user_id', auth()->user()->id);
                $query->orWhere('code', auth()->user()->id);
            }
        })->where(function ($query) {
                if (session('activeArchive')!=0) {
                    $query->where('archive_id', session('activeArchive'));
                }
            })
        ->count();

        $data['operation_day']  = Link::where(function ($query) use ($usersids, $userscodes) {
            if (session()->has('responsiveId')) {
                $query->whereIn('user_id', $usersids)
                    ->orWhere(function ($q) use ($userscodes) {
                        $q->whereIn('code', $userscodes);
                    });
            }
            if (auth()->user()->type == User::TYPE_CLIENT) {
                $query->where('user_id', auth()->user()->id);
                $query->orWhere('code', auth()->user()->id);
            }
        })->where(function ($query) {
                if (session('activeArchive')!=0) {
                    $query->where('archive_id', session('activeArchive'));
                }
            })
        ->whereDate('date', date('Y-m-d'))->count();



        $begin = new DateTime('2023-03-23');
        $end = new DateTime('2023-04-22');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $data['collected_targets'] = [];
        $data['targets'] = [];
        foreach ($period as $dt) {
            $targets = Target::where(function ($query) {
                if (session()->has('responsiveId')) {
                    $query->whereHas('users', function ($q) {
                        $q->where('user_id', session('responsiveId'));
                    });
                }
            })
            ->whereDate('day', $dt->format("Y-m-d"))->where('date_type', 1)->get();
            $collected_targets = 0;
            $targets_count = 0;
            foreach($targets as $target) {
                $targets_count = $target->target + $targets_count;
                if($target->type == 1) {
                    if($target->initiative) {
                        $collected_targets += Link::whereDate('date', $target->day)
                        ->where('section_code', $target->initiative->code)
                        ->where(function ($query) {
                            if (session('activeArchive')!=0) {
                                $query->where('archive_id', session('activeArchive'));
                            }
                        })->sum('total');
                    }
                } elseif($target->type == 2) {
                    $section_code = Initiative::where('path_id', $target->section_id)->pluck('code')->toArray();
                    $collected_targets += Link::whereDate('date', $target->day)
                    ->whereIn('section_code', $section_code)
                    ->where(function ($query) {
                        if (session('activeArchive')!=0) {
                            $query->where('archive_id', session('activeArchive'));
                        }
                    })->sum('total');

                } elseif($target->type == 3) {
                    $collected_targets += Link::whereDate('date', $target->day)
                    ->where('user_id', $target->section_id)
                    ->where(function ($query) {
                        if (session('activeArchive')!=0) {
                            $query->where('archive_id', session('activeArchive'));
                        }
                    })->sum('total');

                } elseif($target->type == 4) {
                    if($target->project) {
                        $collected_targets += Link::whereDate('date', $target->day)
                        ->where('project_number', $target->project->code)
                        ->where(function ($query) {
                            if (session('activeArchive')!=0) {
                                $query->where('archive_id', session('activeArchive'));
                            }
                        })->sum('total');
                    }
                } elseif($target->type == 5) {
                    if($target->category) {
                        $collected_targets += Link::whereDate('date', $target->day)
                        ->where('category_id', $target->category->category_number)
                        ->where(function ($query) {
                            if (session('activeArchive')!=0) {
                                $query->where('archive_id', session('activeArchive'));
                            }
                        })
                        ->sum('total');
                    }
                }
            }
            $data['collected_targets'][] = $collected_targets;
            $data['targets'][] = $targets_count;

        }
        $data['paths'] = $this->getPaths();
        $data['share_links'] =  ShareLink::get() ;
        return view($this->viewIndex, $data);
    }

    public function sallerReport(Request $request)
    {
        if($request->ajax()) {
            $usersids = [];
            if(request()->filled('user_filter')) {
                $usersids = ClientUser::where('user_id', request('user_filter'))->pluck('client_id')->toArray();
            } else {
                $user_ids  =  User::role('mshrf')->pluck('id')->toArray()  ;
                $usersids  = ClientUser::whereIn('user_id', $user_ids)->pluck('client_id')->toArray();
            }
            /* if (session()->has('responsiveId')) {
                 $usersids=ClientUser::where('user_id', session('responsiveId'))->pluck('client_id')->toArray();
             }*/
            $key = "full_name";
            $dir = $request->order[0]['dir'];
            if($request->order[0]['column'] == 1) {
                $key = "amount";
            }
            if($request->order[0]['column'] == 2) {
                $key = "total";
            }
            $data = User::where(function ($query) use ($request, $usersids) {
                if ($request->filled('first_name')) {
                    $query->where('first_name', 'like', '%' . $request->first_name . '%');
                }
                if ($request->filled('mid_name')) {
                    $query->where('mid_name', 'like', '%' . $request->mid_name . '%');
                }
                if ($request->filled('last_name')) {
                    $query->where('last_name', 'like', '%' . $request->last_name . '%');
                }
                /* if($request->filled('user_filter')){
                     $query->whereIn('users.id', $usersids);
                 }*/
            })
                ->where('type', User::TYPE_CLIENT)
                ->where(function ($query) use ($usersids) {
                    if (!empty($usersids)) {
                        $query->whereIn('users.id', $usersids);
                    }
                })
                ->leftJoin('links', function ($query) {
                    $query->where(function ($q) {
                        $q->where(function ($query) {
                            if (session('activeArchive')!=0) {
                                $query->where('archive_id', session('activeArchive'));
                            }
                        });
                    })->on('links.user_id', 'users.id')
                        ->orWhere('links.code', 'users.code');

                })->groupBy('users.id', 'users.first_name', 'users.mid_name', 'users.last_name')
                ->orderBy($key, $dir)
                ->select([DB::raw('count(links.id) as amount'), DB::raw('sum(links.total) as total'), DB::raw("CONCAT(COALESCE(users.first_name,''),' ',COALESCE(users.mid_name,''),' ',COALESCE(users.last_name,'')) AS full_name"),'users.id as user_id','users.phone as user_phone',]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($item) {
                    return $item->full_name;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('last_date', function ($item) {
                    $operation = User::lastOperationDate($item->user_id);
                    if($operation) {
                        return Carbon::createFromFormat('Y-m-d H:i:s', $operation->created_at)->format('H:i Y-m-d ');
                    }
                    return '';

                })
                ->addColumn('archieved', function ($item) {
                    $achived = round((($item->total / 3900) * 100), 2);
                    return $achived . ' %';
                })
            ->addColumn('total', function ($item) {
                return $item->total ?? 0;
            })
            ->rawColumns(['name','amount','total','archieved','last_date'])
            ->make(true);
        }

        /// return   $supervisors = User::role('mshrf')->get() ;
        return view('admin.pages.reports.sallers');
    }
    public function sallerGroup(Request $request)
    {

        $vip = User::where('vip', 1)->pluck('id')->toArray();
        $usersids = ClientUser::whereIn('user_id', $vip)->pluck('client_id')->toArray();
        $data = User::where(function ($query) use ($request) {
            if ($request->filled('first_name')) {
                $query->where('first_name', 'like', '%' . $request->first_name . '%');
            }
            if ($request->filled('mid_name')) {
                $query->where('mid_name', 'like', '%' . $request->mid_name . '%');
            }
            if ($request->filled('last_name')) {
                $query->where('last_name', 'like', '%' . $request->last_name . '%');
            }
        })
            ->where('type', User::TYPE_CLIENT)
            ->whereIn('users.id', $usersids)
            ->leftJoin('links', function ($query) {
                $query->where(function ($q) {
                    $q->where(function ($query) {
                        if (session('activeArchive') != 0) {
                            $query->where('archive_id', session('activeArchive'));
                        }
                    });
                 })->on('links.user_id', 'users.id')
                     ->orWhere('links.code', 'users.code');

             })
           // ->orderBy('links.total','DESC')
            ->groupBy('users.id', 'users.mid_name')
            ->select([DB::raw('count(links.id) as amount'), DB::raw('sum(links.total) as total'), 'users.mid_name','users.id as user_id'])
            ->orderByRaw('SUM(links.total) DESC')
            ->get();


        $map = [];
        $total_amount = 0;
        $total = 0;
        foreach($data as $row) {
            $total_amount += $row->amount;
            $total += $row->total;
            $name = str_replace("مجمع ", "", $row->mid_name);
            $map[$name][] = [
                'amount' => $row->amount,
                'total' => $row->total
            ];
        }

        // dd( $data[0] ) ;
        // return $data ;
        // $data = [];
        // foreach ($map as $key=>$val)
        // {
        //     $total=0;
        //     $amount=0;
        //     foreach ($val as $row)
        //     {
        //         $amount +=$row['amount'];
        //         $total +=$row['total'];
        //     }
        //     $object['name'] = $key;
        //     $object['amount'] = $amount;
        //     $object['total'] = $total;
        //     $data[] = (object)$object;
        // }

        // $data=ksort($data);
        // dd($data);

        return view('admin.pages.reports.sallersGroup', ['data' => $map,'total_amount' => $total_amount,'total_total' => $total]);
    }


    public function export(Request $request)
    {



        //return "ASada" ;
        // return Excel::download(new GroupExport, 'تقرير المجمعات .xlsx');

    }


    public function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    }

    public function dailyreport(Request $request)
    {
        if($request->ajax()) {
            $data = Target::where('day', date('Y-m-d'))->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('section', function ($item) {
                    if($item->type == 1) {
                        return $item->initiative ? $item->initiative->name : '';
                    }
                    if($item->type == 2) {
                        return $item->path ? $item->path->name : '';
                    }
                    if($item->type == 3) {
                        return $item->user ? $item->user->name : '';
                    }
                    if($item->type == 4) {
                        return $item->targetproject ? $item->targetproject->name : '';
                    }
                    if($item->type == 5) {
                        return $item->category ? $item->category->name : '';
                    }
                })
                ->editColumn('type', function ($item) {
                    return ' <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            ' . __('targets.model_types.' . $item->type) . '</button>';
                })
                ->editColumn('date_from', function ($item) {
                    if($item->date_type == 1) {
                        return $item->day;
                    }
                    return $item->date_from;
                })
                ->editColumn('date_to', function ($item) {
                    if($item->date_type == 1) {
                        return $item->day;
                    }
                    return $item->date_to;
                })
                ->editColumn('achieved', function ($item) {
                    if($item->type == 1) {
                        if($item->initiative) {
                            return Link::where(function ($query) use ($item) {
                                if($item->date_type == 1) {
                                    $query->where('date', $item->day);
                                } else {
                                    $query->whereBetween('date', [$item->date_from,$item->date_to]);
                                }
                            })
                            ->where('section_code', $item->initiative->code)
                            ->sum('total');
                        }
                    } elseif($item->type == 2) {

                        $section_code = Initiative::where('path_id', $item->section_id)->pluck('code')->toArray();
                        return Link::where(function ($query) use ($item) {
                            if($item->date_type == 1) {

                                $query->where('date', $item->day);
                            } else {
                                $query->whereBetween('date', [$item->date_from,$item->date_to]);
                            }
                        })
                        ->whereIn('section_code', $section_code)
                        ->sum('total');

                    } elseif($item->type == 3) {
                        return Link::where(function ($query) use ($item) {
                            if($item->date_type == 1) {

                                $query->where('date', $item->day);
                            } else {
                                $query->whereBetween('date', [$item->date_from,$item->date_to]);
                            }
                        })
                        ->where('user_id', $item->section_id)
                        ->sum('total');
                    } elseif($item->type == 4) {
                        if($item->project) {
                            return Link::where(function ($query) use ($item) {
                                if($item->date_type == 1) {
                                    $query->where('date', $item->day);
                                } else {
                                    $query->whereBetween('date', [$item->date_from,$item->date_to]);
                                }
                            })
                            ->where('project_number', $item->project->code)
                            ->sum('total');
                        }
                    } elseif($item->type == 5) {
                        if($item->category) {
                            return Link::where(function ($query) use ($item) {
                                if($item->date_type == 1) {

                                    $query->where('date', $item->day);
                                } else {
                                    $query->whereBetween('date', [$item->date_from,$item->date_to]);
                                }
                            })
                            ->where('category_id', $item->category->category_number)
                            ->sum('total');
                        }
                    }
                })
                ->rawColumns(['section','project','target','achieved','type','date_from','date_to'])
                ->make(true);
        }

        return view('admin.pages.reports.daily_target');
    }
    public function whatsappReport(Request $request)
    {
        if($request->ajax()) {
            $data = ProjectMessage::with('project')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('project', function ($item) {
                    return $item->project ? $item->project->name : '';
                })
                ->addColumn('category', function ($item) {
                    return $item->project ? $item->project->category->name : '';
                })
                ->addColumn('current_percent', function ($item) {
                    if($item->project) {
                        $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                        if($next_message) {
                            $total = Link::where('project_number', $item->project->code)->whereBetween('created_at', [$item->created_at,$next_message->created_at])->sum('total');
                        } else {
                            $total = Link::where('project_number', $item->project->code)->whereDate('created_at', '>', $item->created_at)->sum('total');
                        }
                        if(($item->project->price * $item->project->quantityInStock) > 0) {
                            $percent = ($total / ($item->project->price * $item->project->quantityInStock)) * 100;
                            return $percent > 0 ? round($percent, 2) : 0;
                        }
                        return 0;

                    }

                })
                ->addColumn('current_archived', function ($item) {
                    if($item->project) {
                        $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                        if($next_message) {
                            return $item->archieved + Link::where('project_number', $item->project->code)->whereBetween('created_at', [$item->created_at,$next_message->created_at])->sum('total');
                        } else {
                            return $item->archieved + Link::where('project_number', $item->project->code)->whereDate('created_at', '>', $item->created_at)->sum('total');
                        }
                    }
                })
                ->addColumn('diffrence', function ($item) {
                    if($item->project) {
                        $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                        $next_message = ProjectMessage::where('id', '>', $item->id)->where('project_id', $item->project_id)->first();
                        if($next_message) {
                            $total = $item->archieved +  Link::where('project_number', $item->project->code)->whereBetween('created_at', [$item->created_at,$next_message->created_at])->sum('total');
                        } else {
                            $total = $item->archieved +  Link::where('project_number', $item->project->code)->whereDate('created_at', '>', $item->created_at)->sum('total');
                        }

                        if($item->archieved) {

                            return $total - $item->archieved;
                        }
                        $item_archieved = Link::where('project_number', $item->project->code)->whereDate('created_at', '<', $item->created_at)->sum('total');
                        return $total - $item_archieved;

                    }
                })

            ->rawColumns(['current_percent','current_archived','project','diffrence','category'])
            ->make(true);
        }

        return view('admin.pages.reports.whatsappreport');
    }



    public function getPaths()
    {
        $paths = Path::all();
        $data['total_collected'] = [];
        $data['total_target'] = [];
        $data['path_name'] = [];
        $data['path_id'] = [];
        foreach($paths as $path) {
            if(count($path->initiatives) == 0) {
                continue;
            }
            $initiatives = $path->initiatives()->pluck('id');
            $targets = Target::where(function ($query) {
                //     if (session()->has('responsiveId')) {
                //     $query->whereHas('users', function ($q) {
                //         $q->where('user_id',session('responsiveId'));
                //     });
                // }
            })
            ->where('date_type', 1)->where('type', 1)->whereIn('section_id', $initiatives)->get();
            $collected_targets = 0;
            $targets_count = 0;
            // dd($targets);
            foreach($targets as $target) {
                $targets_count = $target->target + $targets_count;
                if($target->initiative) {
                    $collected_targets += Link::whereDate('date', $target->day)
                    ->where('section_code', $target->initiative->code)
                    ->sum('total');
                }
            }
            $data['total_collected'][] = $collected_targets;
            $data['total_target'][] = $targets_count;
            $data['path_name'][] = $path->name;
            $data['path_id'][] = $path->id;
        }
        $collection = [];
        $i = 0;
        foreach($data['path_id'] as $path_id) {
            $object['collected'] = $data['total_collected'][$i];
            $object['target'] = $data['total_target'][$i];
            if(($data['total_target'][$i] > 0)) {
                $object['percent'] = round(($data['total_collected'][$i] / $data['total_target'][$i]) * 100, 2);
            } else {
                $object['percent'] = 0;
            }
            $object['nededd'] = $data['total_target'][$i] - $data['total_collected'][$i];
            $object['name'] = $data['path_name'][$i];
            $object['id'] = $data['path_id'][$i];
            $i++;
            $collection[] = (object) $object;

        }
        return $collection;
    }
    public function fixQuery()
    {

        $total_projects = DB::table('views_project_un_compleated')->get();

        $data = Link::join('users', 'users.code', 'links.code')
        ->whereNull('links.user_id')
        ->select(['links.code','users.id as user_id','links.id'])->get();
        foreach($data as $row) {
            Link::where('id', $row->id)->update(['user_id' => $row->user_id]);
        }
        flash(__('admin.messages.updated'))->success();
        return back();


    }


    public function updateProjectMessage()
    {
        $messages = ProjectMessage::with('project')->get();
        foreach($messages as $message) {
            if($message->project) {
                $phones = Link::where('project_number', $message->project->code)->where('created_at', '<', $message->created_at)->pluck('phone')->toArray();
                if(count($phones) > 0) {
                    $message->phone_numbers = count($phones);
                    $message->sendding_numbers = $phones;
                    $message->save();
                }
            }
        }

    }







}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\Reminder;
use App\Models\WhatsappSetting;
use App\Models\ProjectReminder;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.settings.index');
    }

    public function userLinks()
    {
        $data=Link::join('users', 'users.code', 'links.code')
        ->whereNull('links.user_id')
        ->select(['links.code','users.id as user_id','links.id'])->get();
        foreach($data as $row) {
            Link::where('id', $row->id)->update(['user_id'=>$row->user_id]);
        }
        flash(__('admin.messages.updated'))->success();
        return back();
    }

    public function projectLinks()
    {
        $data=Link::join('projects', 'projects.code', 'links.project_number')
        ->whereNull('links.project_number')
        ->select(['projects.code as project_code','links.id as link_id'])->get();
        foreach($data as $row) {
            Link::where('id', $row->link_id)->update(['project_number'=>$row->project_code]);
        }
        flash(__('admin.messages.updated'))->success();
        return back();
    }

    public function categoryLinks()
    {
        $data=Link::join('categories', 'categories.id', 'links.category_id')
        ->whereNull('links.category_id')
        ->select(['categories.id as category_id','links.id as link_id'])->get();
        foreach($data as $row) {
            Link::where('id', $row->link_id)->update(['category_id'=>$row->category_id]);
        }
        flash(__('admin.messages.updated'))->success();
        return back();
    }

    public function whats(Request $request, WhatsappService $whats)
    {
        try {
            $numbers = [];
            $categories = WhatsappSetting::with('phone')->whereHas('phone')->get();
            foreach($categories as $category) {
                $projects_ids=ProjectMessage::where('percent_id', $category->id)->pluck('project_id')->toArray();
                $projects = Project::whereNotIn('projects.id', $projects_ids)
                ->where('projects.category_id', $category->category_id)
                ->leftJoin('links', 'projects.code', 'links.project_number')
                ->groupBy('projects.id')
                ->select([
                        'projects.code as code',
                        'projects.id',
                        'projects.name',
                        'projects.category_id',
                        DB::raw('sum(links.total) as total_done'),
                        'projects.price',
                        'projects.quantityInStock'
                    ])->get();
                foreach($projects as $project) {
                    $user_phones = Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();
                    $target = $project->price * $project->quantityInStock;
                    if(count($user_phones)==0) {
                        continue;
                    }
                    if($target==0) {
                        continue;
                    }
                    $percent=(($project->total_done / $target) * 100);
                    if(($category->percent <= $percent) && (($percent) <= $category->percent2)) {
                        foreach($user_phones as $phone) {
                            $project_link = "https://give.qb.org.sa/P/" . $project->code;
                            $message = str_replace('project_name', $project->name, $category->message);
                            $message = str_replace('project_link', $project_link, $message);
                            $message = str_replace('percent', round($percent), $message);
                            $whats->send(formate_phone_number($phone), $message, $category->phone->listen_id, $category->phone->token_id);
                            sleep(1);
                            $numbers[] =$phone;
                        }
                        ProjectMessage::create(['project_id'=>$project->id,'percent_id'=>$category->id,'percent'=>$percent,'archieved'=>$project->total_done,'phone_numbers'=>count($user_phones),'sendding_numbers'=>json_encode($user_phones)]);
                    }
                }
            }
        } catch (Exception $e) {
            // DB::rollback();
        }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }

    public function reminders(Request $request)
    {
        try {
            $whats=new WhatsappService();
            $numbers = [];
            $reminders = Reminder::with('phone')->whereHas('phone')->get();
            foreach($reminders as $reminder) {
                $projects_ids=ProjectReminder::where('reminder_id', $reminder->id)->pluck('project_id')->toArray();
                $projects = Project::whereNotIn('id', $projects_ids)
                ->where('category_id', $reminder->category_id)
                ->select([
                    'id',
                    'code',
                    'name',
                    ])->get();
                foreach($projects as $project) {
                    $last_operation=Link::where('project_number', $project->code)
                    ->where('message_start', '>', '2023-04-12 14:20:28')
                    ->orderBy('id', 'DESC')
                    ->first();
                    if($last_operation) {
                        if($last_operation->created_at <= (Carbon::now()->subDays($reminder->day_number)->toDateTimeString())) {
                            $phones=Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();
                            $project_link = "https://give.qb.org.sa/P/" . $project->code;
                            $message = str_replace('project_name', $project->name, $reminder->message);
                            $message = str_replace('project_link', $project_link, $message);
                            foreach($phones as $phone) {
                                // $whats->send(formate_phone_number($phone), $message,$reminder->phone->listen_id,  $reminder->phone->token_id);
                                // sleep(1);
                                $numbers[] = $phone;
                            }
                        }
                        ProjectReminder::create(['project_id'=>$project->id,'reminder_id'=>$reminder->id]);
                    }
                }
            }
        } catch (Exception $e) {
            // DB::rollback();
        }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }

    public function getCountProject(Request $request, WhatsappService $whats)
    {
        $numbers30 = 0;
        $numbers60 = 0;
        $numbers80 = 0;
        $numbers85 = 0;
        $projects = Project::leftJoin('links', 'projects.code', 'links.project_number')
        ->groupBy('projects.id')
        ->select([
                'projects.code as code',
                'projects.id',
                'projects.name',
                'projects.category_id',
                DB::raw('sum(links.total) as total_done'),
                'projects.price',
                'projects.quantityInStock'
            ])->get();
        foreach($projects as $project) {

            $target = $project->price * $project->quantityInStock;

            if($target==0) {
                continue;
            }
            $percent=(($project->total_done / $target) * 100);
            if((30 <= $percent) && (($percent) < 60)) {
                $numbers30++;
            }
            if((60 <= $percent) && (($percent) < 80)) {
                $numbers60++;
            }
            if((80 <= $percent) && (($percent) <= 85)) {
                $numbers80++;
            }
            if((85 <= $percent)) {
                $numbers85++;
            }
        }

        dd(['30'=>$numbers30,'60'=>$numbers60,'80'=>$numbers80,'85'=>$numbers85]);
        flash(__('admin.messages.updated'))->success();
        // return view('admin.pages.settings.index',['numbers'=>$numbers]);
    }
    public function updateProject(Request $request, WhatsappService $whats)
    {
        $numbers = [];
        $messages=ProjectMessage::whereNull('percent')->get();
        foreach($messages as $item) {
            $project = Project::where('projects.id', $item->project_id)
            ->leftJoin('links', 'projects.code', 'links.project_number')
            ->groupBy('projects.id')
            ->select([
                    'projects.code as code',
                    'projects.id',
                    'projects.name',
                    'projects.category_id',
                    DB::raw('sum(links.total) as total_done'),
                    'projects.price',
                    'projects.quantityInStock'
                ])->whereDate('links.created_at', '<=', $item->created_at)->first();
            if($project) {
                $target = $project->price * $project->quantityInStock;
                if($target==0) {
                    continue;
                }
                $percent=(($project->total_done / $target) * 100);
                $item->update(['percent'=>$percent,'archieved'=>$project->total_done]);
            }
        }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }
    public function updateProjectImage(Request $request, WhatsappService $whats)
    {
        $numbers = [];
        $categories = WhatsappSetting::with('phone')->whereHas('phone')->get();
        // $projects_ids = [1037,1273,1787];
        foreach($categories as $category) {
            $projects = Project::where('projects.category_id', $category->category_id)
            ->leftJoin('links', 'projects.code', 'links.project_number')
            ->where('projects.message', 0)
            ->groupBy('projects.id')
            ->select([
                    'projects.code as code',
                    'projects.id',
                    'projects.name',
                    'projects.category_id',
                    DB::raw('sum(links.total) as total_done'),
                    'projects.price',
                    'projects.quantityInStock'
                ])->get();
            foreach($projects as $project) {
                $target = $project->price * $project->quantityInStock;
                if($target==0) {
                    continue;
                }
                $percent=(($project->total_done / $target) * 100);
                if($percent >= 100) {

                    $project->message = 1;
                    $project->save();
                    $numbers[] = $project->code;
                }
            }
        }

        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }

    public function whatsImage(Request $request, WhatsappService $whats)
    {
        ini_set('max_execution_time', 1048);

        //   try {
        $numbers = [];
        $projects = Project::with(['category','category.phone'])->leftJoin('links', 'projects.code', 'links.project_number')
        ->whereIn('projects.category_id', [12,14,18,19,20,21,22])
        ->where('projects.id', '>', 6379)
        ->groupBy('projects.id')
        ->select([
                'projects.code as code',
                'projects.id',
                'projects.name',
                'projects.category_id',
                DB::raw('sum(links.total) as total_done'),
                'projects.price',
                'projects.quantityInStock'
            ])->get();
        foreach($projects as $project) {
            $user_phones = Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();
            $image= wirte_text_image(arabic_utf8($project->name)) ;
            $target = $project->price * $project->quantityInStock;
            if($target==0) {
                continue;
            }
            $percent=(($project->total_done / $target) * 100);
            if($percent >= 100) {
                $numbers[] = $project->code;
                // $project->message = 1;
                // $project->save();
                $image= wirte_text_image(arabic_utf8($project->name)) ;
                foreach($user_phones as $phone) {
                    $numbers[] =$phone;
                    if($project->category && $project->category->phone) {
                        $whats->sendImage(formate_phone_number($phone), $image, $project->category->phone->listen_id, $project->category->phone->token_id);
                        //   $whats->sendImage("+201159153248", $image, $project->category->phone->listen_id, $project->category->phone->token_id);
                        $numbers['phone'][] =   $project->category->phone;
                    }

                    sleep(1);
                    //   dd([$user_phones, $project->code]);
                }
                $project->message = 1;
                $project->save();
            }
        }
        //   } catch (Exception $e) {
        //       DB::rollback();
        //   }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }
    public function whatsImageCompleate(Request $request, WhatsappService $whats)
    {
        ini_set('max_execution_time', 1048);
        try {
        $numbers = [];
        $projects = Project::with(['category','category.phone'])->leftJoin('links', 'projects.code', 'links.project_number')
        ->whereIn('projects.category_id', [23,24,25,26])
        ->where('message', 0)
        ->groupBy('projects.id')
        ->select([
                'projects.code as code',
                'projects.id',
                'projects.name',
                'projects.category_id',
                DB::raw('sum(links.total) as total_done'),
                'projects.price',
                'projects.quantityInStock'
            ])->havingRaw('(total_done/(projects.quantityInStock*projects.price))>=1')->get();
            $numbers = [] ;
            foreach($projects as $project) {
                $user_phones = Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();
                if(count($user_phones)==0){
                    continue;
                }
                $image= wirte_text_image_hour(arabic_utf8($project->name));

                if($project->category && $project->category->phone) {
                    $project->message = 1;
                    $project->save();
                    foreach($user_phones as $phone) {
                            $numbers[] =$phone;
                        $whats->sendImage(formate_phone_number($phone), $image,$project->category->phone->listen_id, $project->category->phone->token_id);
                        // $whats->sendImage("+201159153248", $image, $project->category->phone->listen_id, $project->category->phone->token_id);
                        $numbers['phone'][] = $project->category->phone;
                        sleep(1);
                    }
                }

            }
          } catch (Exception $e) {
              DB::rollback();
          }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers'=>$numbers]);
    }
}

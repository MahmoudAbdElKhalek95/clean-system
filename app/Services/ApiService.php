<?php

namespace App\Services;

use App\Models\Archive;
use App\Models\Category;
use App\Models\DonnerAmount;
use App\Models\Link;
use App\Models\Project;
use App\Models\ProjectCode;
use App\Models\ProjectMessage;
use App\Models\ProjectReminder;
use App\Models\Reminder;
use App\Models\Section;
use App\Models\User;
use App\Models\WhatsappSetting;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    public function getData()
    {
        $start=mktime(date('H'),date('i', strtotime('-7 minutes')),date('s'),date('m'),date('d'),date("Y"));
        $end=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date("Y"));
        $unix_time = $start.','.$end;
        try {
            date_default_timezone_set("Asia/Riyadh");
            $body = [
                "k" => config('project.api.secret_key'),
                "ts" => $unix_time
            ];

            $response = Http::asForm()->post(config('project.api.url').'?ts='.$unix_time, $body);
            if($response->ok()) {
                $data = $response->json();
                Log::info($data['results']);
                foreach($data['results'] as $row) {

                    try {
                        $link = Link::where('link_id', $row['paymentId'])->where('project_number', $row['projectId'])->first();
                        if($link) {
                            continue;
                        }
                        $date = date('Y-m-d', strtotime($row['paymentDate']));
                        $time = date('H:i:s', strtotime($row['paymentDate']));
                        $archive = Archive::where('status', 1)->first();
                        $acive_archive = $archive ? $archive->id : null;
                        $user = User::Where('code', $row['referenceCode'])->whereNotNull('code')->first();
                        $section_code = preg_replace('/\d+/u', '', $row['referenceCode']);
                        $section = Section::where('code', $section_code)->first();
                        $input = [
                            'project_name' => $row['projectName'],
                            'project_dep_name' => $row['categoryName'],
                            'category_id' => $row['categoryId'],
                            'amount' => $row['quantity'],
                            'price' => $row['price'],
                            'link_id' => $row['paymentId'],
                            'phone' => $row['phoneNumber'] ?? '',
                            'total' => $row['total'],
                            'date' => $date,
                            'oprtayion_time' => $time,
                            'section_code' => $section_code,
                            'project_number' => $row['projectId'],
                            'section_id' => $section ? $section->id : null,
                            'referenceCode' => $row['referenceCode'],
                            'archive_id' => $acive_archive,
                            'user_id' => $user ? $user->id : null,
                            'created_at'=>$row['paymentDate']
                        ];
                        Link::create($input);
                        if(key_exists('phoneNumber', $row)) {
                            $donner = DonnerAmount::where('phone', $row['phoneNumber'])->first();
                            if ($donner) {
                                $donner->amount = $donner->amount + 1;
                                $donner->total = $donner->total + $row['total'];
                                $donner->save();
                            } else {
                                $donner = DonnerAmount::create([
                                    'amount' => 1,
                                    'total' => $row['total'],
                                    'phone' => $row['phoneNumber'] ?? '',

                                ]);
                            }
                        }
                    } catch(Exception $e) {
                        Log::info($e->getMessage());
                        continue;
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }

    public function getProjects()
    {
        // try {
            date_default_timezone_set("Asia/Riyadh");
            $body = [
                "k" => config('project.api.secret_key'),
            ];
            $response = Http::asForm()->post(config('project.api.project_url'), $body);
            if($response->ok()) {
                $data = $response->json();
                foreach($data['results'] as $row) {
                    // try {
                        $project = Project::where('code', $row['projectId'])->first();
                        $category = Category::where('category_number', $row['categoryId'])->first();
                        if($category == null) {
                            $category = Category::create(
                                [
                                    'category_number' => $row['categoryId'],
                                    'name' => $row['categoryCategoryName']
                                ]
                            );
                        }
                        $input = [
                            'name' => $row['name'],
                            'code' => $row['projectId'],
                            'quantityInStock' => $row['quantityInStock'],
                            'price' => $row['price'],
                            'totalSalesTarget' => $row['totalSalesTarget'],
                            'totalSalesDone' => $row['totalSalesDone'],
                            'category_id' => $category->id,
                        ];
                        if($project) {
                            $project->update($input);
                        } else {
                            Project::create($input);
                        }
                    // } catch(Exception $e) {
                    //     continue;
                    // }
                }
            }
        // } catch (Exception $e) {
        //     Log::error($e->getMessage());
        //     Log::error('', $e->getTrace());
        // }
    }

    public function updateProjects()
    {
        try {
            date_default_timezone_set("Asia/Riyadh");
            $data = ProjectCode::with('project')->get();
            foreach($data as $row) {
                $user = User::Where('code', $row->code)->first();
                if($user) {
                    $section_code = preg_replace('/\d+/u', '', $row->code);
                    // $section = Section::where('code', $section_code)->first();
                    Link::where('project_number', $row->project->code)->update(['user_id' => $user->id,'section_code' => $section_code]);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error('', $e->getTrace());
        }
    }

    public function sendWhatsMessages()
    {
        try {
            $whats = new WhatsappService();
            $numbers = [];
            $categories = WhatsappSetting::with('phone')->whereHas('phone')->get();
            foreach($categories as $category) {
                $projects_ids = ProjectMessage::where('percent_id', $category->id)->pluck('project_id')->toArray();
                $projects = Project::whereNotIn('projects.id', $projects_ids)
                ->where('projects.category_id', $category->category_id)
                ->where('projects.id', 3554)
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
                    if(count($user_phones) == 0) {
                        continue;
                    }
                    if($target == 0) {
                        continue;
                    }
                    $percent = (($project->total_done / $target) * 100);
                    if(($category->percent <= $percent) && (($percent) <= $category->percent2)) {
                        foreach($user_phones as $phone) {
                            $project_link = "https://give.qb.org.sa/P/" . $project->code;
                            $message = str_replace('project_name', $project->name, $category->message);
                            $message = str_replace('project_link', $project_link, $message);
                            $message = str_replace('percent', round($percent), $message);
                            $whats->send(formate_phone_number($phone), $message, $category->phone->listen_id, $category->phone->token_id);
                            sleep(2);
                            $numbers[] = $phone;
                        }
                        ProjectMessage::create(['project_id' => $project->id,'percent_id' => $category->id,'percent' => $percent,'archieved' => $project->total_done,'phone_numbers' => count($user_phones),'sendding_numbers' => json_encode($user_phones)]);
                    }
                }
            }
            log::info($numbers);
        } catch (Exception $e) {
            Log::error('', $e->getTrace());
        }
    }

    public function whatsImage()
    {
        try {
            $whats = new WhatsappService();
            $numbers = [];
            $projects = Project::leftJoin('links', 'projects.code', 'links.project_number')
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
                $user_phones = Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();
                $target = $project->price * $project->quantityInStock;
                if($target == 0) {
                    continue;
                }
                $percent = (($project->total_done / $target) * 100);
                if($percent >= 100) {
                    $image = wirte_text_image(arabic_utf8($project->name)) ;
                    foreach($user_phones as $phone) {
                        if($project->category && $project->category->phone) {
                            $numbers[] = $phone;
                            $whats->sendImage(formate_phone_number($phone), $image, $project->category->phone->listen_id, $project->category->phone->token_id);
                            sleep(1);
                        }
                    }
                    $project->message = 1;
                    $project->save();
                }
            }
        } catch (Exception $e) {
            DB::rollback();
        }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index', ['numbers' => $numbers]);
    }

    public function reminders()
    {
        try {
            $whats = new WhatsappService();
            $numbers = [];
            $reminders = Reminder::with('phone')->whereHas('phone')->get();
            foreach($reminders as $reminder) {
                $projects_ids = ProjectReminder::where('reminder_id', $reminder->id)->pluck('project_id')->toArray();
                $projects = Project::whereNotIn('id', $projects_ids)
                ->where('category_id', $reminder->category_id)
                ->select([
                    'id',
                    'code',
                    'price',
                    'quantityInStock',
                    'name',
                    ])->get();
                foreach($projects as $project) {
                    $last_operation = Link::where('project_number', $project->code)
                    ->where('message_start', '>', '2023-04-12 14:20:28')
                    ->orderBy('id', 'DESC')
                    ->first();
                    if($last_operation) {
                        if($last_operation->created_at <= (Carbon::now()->subDays($reminder->day_number)->toDateTimeString())) {
                            $target = $project->price * $project->quantityInStock;
                            if($target > 0) {
                                $total_done = Link::where('project_number', $project->code)->sum('total');
                                if((($target / $total_done) * 100) > 100) {
                                    ProjectReminder::create(['project_id' => $project->id,'reminder_id' => $reminder->id]);
                                    continue;
                                }
                            }
                            $phones = Link::where('project_number', $project->code)->groupBy('phone')->pluck('phone')->toArray();

                            $project_link = "https://give.qb.org.sa/P/" . $project->code;
                            $message = str_replace('project_name', $project->name, $reminder->message);
                            $message = str_replace('project_link', $project_link, $message);
                            foreach($phones as $phone) {
                                $whats->send(formate_phone_number($phone), $message, $reminder->phone->listen_id, $reminder->phone->token_id);
                                sleep(1);
                                $numbers[] = $phone;
                            }
                        }
                        ProjectReminder::create(['project_id' => $project->id,'reminder_id' => $reminder->id]);
                    }
                }
            }
        } catch (Exception $e) {
            // DB::rollback();
        }
        flash(__('admin.messages.updated'))->success();
        return view('admin.pages.settings.index');
    }


    public function serviceStatus(): bool
    {
        try {
            $response = Http::get(config('turbo.whatsapp.base_url'));
            return $response->ok();
        } catch (\Exception $e) {
            return false;
        }
    }
}

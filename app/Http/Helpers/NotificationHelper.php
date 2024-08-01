<?php

namespace App\Http\Helpers;

use App\Jobs\SendNotification;
use App\Models\Notification;
use App\Models\NotificationUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationHelper
{
    private string $firebase_api_token;
    private array $registeration_ids;

    private array $data;

    private string $message;

    private string $users;

    private string|int $notifiable_id;

    private array $notificationData;

    public function __construct()
    {
        $this->registeration_ids = [];
        $this->users = '';
        $this->data = [];
        $this->notifiable_id = '';
        $this->firebase_api_token = config('project.firebase.token');
    }



    public function setNotifiableId(string|int $id): void
    {
        $this->notifiable_id = $id;
    }
    private function fetchRegisterationIds(): void
    {
        $query = 'SELECT firebase_token FROM oauth_access_tokens WHERE oauth_access_tokens.user_id IN ( '.$this->users.' ) GROUP BY firebase_token';
        $this->registeration_ids = array_column(DB::select(DB::raw($query)), 'firebase_token');
    }

    public function push(int $user_id): void
    {
        if ($this->users != '') {
            $this->users .= ',';
        }
        $this->users .= $user_id;
    }

    public function clearUsers(): void
    {
        $this->users = '';
    }

    public function setMessage(string|array|null $message): void
    {
        $this->message = $message;
    }

    public function pushData(string $key, string|int|null $value): void
    {
        $this->data[$key] = $value;
    }

    public function pushNotifyAttr(string $key, string|bool $value): void
    {
        $this->notificationData[$key] = $value;
    }

    public function create(int|string|null $created_by = null): array
    {
        $response = [];
        $response['success'] = 1;
        $response['error_msg'] = '';
        DB::beginTransaction();
        try {
            $notification = new Notification();
            $notification->message = $this->message;
            $notification->notifiable_id = $this->notifiable_id ?? '';
            $notification->created_by = isset($created_by) ? $created_by : auth()->id();
            $notification->updated_by = isset($created_by) ? $created_by : auth()->id();
            if (! $notification->save()) {
                throw new \Exception();
            }

            $arr = [];
            foreach (explode(',', $this->users) as $user) {
                $arr[] = [
                    'user_id' => $user,
                    'notification_id' => $notification->id,
                ];
                $notificationObject = [
                    'notification_id' => $notification->id ?? '',
                    'notifiable_id' => $this->notifiable_id ?? '',
                    'message' => $this->message,
                    'notification_date' => Carbon::now()->toDateString(),
                    'notification_time' => Carbon::now()->toTimeString(),
                ];
            }
            if (count($arr) > 0) {
                $this->pushData('notification_id', $notification->id);
                NotificationUser::insert($arr);
                $this->fire();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response['success'] = 0;
            $response['error_msg'] = $e->getMessage();
        }

        return $response;
    }
    public function fire(): bool
    {
        foreach (explode(',', $this->users) as $user) {
            $full_count_query = 'SELECT count(`notification`.id) as f_count FROM notification JOIN notification_user ON notification_user.notification_id = notification.id  where notification_user.user_id='.$user.' and notification.is_read = 0';
        }
        $this->pushData('click_action', 'FLUTTER_NOTIFICATION_CLICK');
        $this->pushData('notifiable_id', $this->notifiable_id);
        $this->pushNotifyAttr('body', $this->message);
        $this->pushNotifyAttr('priority', 'high');
        $this->pushNotifyAttr('content_available', true);

        $this->fetchRegisterationIds();
        SendNotification::dispatch($this->registeration_ids, $this->data, $this->firebase_api_token, $this->notificationData);
        return true;
    }
}

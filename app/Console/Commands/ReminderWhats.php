<?php

namespace App\Console\Commands;

use App\Services\ApiService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReminderWhats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('reminder:message command is starting now');
        try {
            $api = new ApiService();
            $api->reminders();
        } catch (Exception $e) {
            Log::error('', $e->getTrace());
        }
        $this->info('reminder:message command is finshed now');
    }
}

?>

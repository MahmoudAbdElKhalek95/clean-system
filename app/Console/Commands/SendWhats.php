<?php

namespace App\Console\Commands;

use App\Services\ApiService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendWhats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:messages';

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
        $this->info('send:messages command is starting now');
        try {
            $api = new ApiService();
            $api->sendWhatsMessages();
        } catch (Exception $e) {
            Log::error('', $e->getTrace());
        }
        $this->info('send:messages command is finshed now');
    }
}

?>

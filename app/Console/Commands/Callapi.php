<?php

namespace App\Console\Commands;

use App\Services\ApiService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class Callapi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:api';

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
        $this->info('call:api command is starting now');
        try {
            $request = new ApiService();
             $request->getProjects();
            $request->getData();
            // $request->updateProjects();
        } catch (Exception $e) {
            DB::rollback();
        }
        $this->info('call:api command is finshed now');
    }
}

?>

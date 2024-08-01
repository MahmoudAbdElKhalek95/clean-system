<?php

namespace App\Console\Commands;

use App\Services\ApiService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class Callprojects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:projects';

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
        $this->info('call:projects command is starting now');
        try {
            DB::beginTransaction();
            $request = new ApiService();
            $request->getProjects();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        $this->info('call:projects command is finshed now');
    }
}

?>

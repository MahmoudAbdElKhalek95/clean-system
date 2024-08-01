<?php

namespace App\Imports;

use App\Models\BlackList;
use App\Models\Target;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class BlackListExport implements ToCollection
{
  /*  private  $data;
    public function __construct( $data)
    {
        $this->data = $data;
    }

    */

    /**
     * @param Collection $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $key => $row) {
                // if ($key < 1 || $row[0] == null || $row[0] == ' ') {
                //     continue;
                // }
                if (empty($row[0])) {
                    if($row[0]==0){
                    }else{

                        throw new \Exception(__('targets.errors.target_required').' '.$key + 1);
                    }
                }
                $created = $this->createTarget($row);
                if (! $created) {
                    flash(__('targets.row_faild_at_row').' ====> '.$key + 1)->error();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash($e->getMessage())->error();
        }
    }


    public function createTarget( $row): bool
    {
        DB::beginTransaction();
                try {
                    $target = BlackList::create([
                       // 'type_id' => $this->data['type_id'],
                       // 'name' => $row[0],
                        'phone' =>$row[0],
                    ]);
                    if ($target) {
                        // $target->users()->detach();
                        // $target->users()->attach($this->data['user_id']);

                        DB::commit();
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::info($e->getMessage());
                    return false;
                }
        return true;
    }

}

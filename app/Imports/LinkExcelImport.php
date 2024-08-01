<?php

namespace App\Imports;

use App\Models\Archive;
use App\Models\Category;
use App\Models\Link;
use App\Models\Project;
use App\Models\Section;
use App\Models\Target;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class LinkExcelImport implements ToCollection
{
    public function __construct()
    {
    }


    /**
     * @param Collection $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        // try {
            // DB::beginTransaction();

            $archive = Archive::where('status', 1)->first();
            $acive_archive = $archive ? $archive->id : null;

            foreach($rows as $key=>$row) {
                 if ($key < 1 || $row[0] == null || $row[0] == ' ') {
                    continue;
                }
                $link = Link::where('link_id', $row[0])->where('project_number', $row[6])->first();
                if($link) {
                    continue;
                }
                $project = Project::where('code', $row[0])->first();
                $category = Category::where('category_number', $row[8])->first();
                if($category == null) {
                    $category = Category::create(
                        [
                            'category_number' => intval($row[8]),
                            'name' => $row[9]
                        ]
                    );
                }

                $date = intval($row[11]);
                $day = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');

                $input = [
                    'project_name' => $row[7],
                    'project_dep_name' => $row[9],
                    'category_id' => $category->id,
                    'amount' => (float)$row[3],
                    'price' => (float)$row[4],
                    'link_id' => $row[0],
                    'phone' => $row[10] ?? '',
                    'total' => $row[5],
                    'date' => $day,
                    'project_number' => $row[6],
                    'archive_id' => $acive_archive,

                ];
                Link::create($input);
            }

            // DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     flash($e->getMessage())->error();
        // }
    }


    public function createTarget( $row): bool
    {
        DB::beginTransaction();
                try {
                    $date = intval($row[0]);
                    $day=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                    $target = Target::create([

                        'day' => $day,
                        'target' => $row[1],
                        'date_type' => 1,
                    ]);
                    if ($target) {
                         $target->users()->detach();

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

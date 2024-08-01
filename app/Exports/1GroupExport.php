<?php
namespace App\Exports;
use App\Models\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

 class GroupExport implements FromQuery, WithHeadings, WithEvents , ShouldQueue , WithMapping

{

    use Exportable ;

    public $data ;

    public function __construct( $data )
    {
        $this->data = $data;

    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    public function headings(): array
    {
       // return Schema::getColumnListing('students');

       return [

        ' الاسم',
        ' إسم المستخدم',
        '  البريد الإلكتروني ',
        ' الجهة',
        ' الهاتف ',
        ' رقم الهوية ',
        ' المرحلة الدراسية ',
        '  الحلقة ',
        ' التاريخ ',
        ' الحالة ',
        ' رقم جوال ولي الامر ',
        ' المستوي ',

      ];

    }


    // query

    public function query ()
    {

        $Student =  $this->data ;

        return $Student ;

    }


    public function map($item): array
    {
        return [

        $item->first_name . " " . $item->last_name  ,
        $item->user->username  ?? null  ,

        $item->user->email ?? null  ,

        $item->company->name ?? null,

        $item->phone  ?? null ,

        $item->national_id ?? null ,

        $item->educationLevel->name  ?? null ,
        $item->classes->name ?? null ,

        $item->joined_date  ?? null ,

        $item->status == 1 ? ' مستمر' :    'غير مستمر'  ,
        $item->parent->phone ?? null ,

         $item->studentRankName() ?? null ,


        ];
    }



}

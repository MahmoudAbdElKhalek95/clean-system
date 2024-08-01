<?php

namespace App\Models;

use App\Services\TimezoneFormat;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Link extends Model
{
    use HasFactory;
    // use TimezoneFormat;

    protected $table = "links";
    protected $fillable = [
        'project_name',
        'project_dep_name',
        'amount',
        'price',
        'date',
        'project_number',
        'code',
        'section_id',
        'section_code',
        'user_id',
        'total',
        'phone',
        'oprtation_type',
        'category_id',
        'link_id',
        'operation_time',
        'archive_id'
    ];

    public const TYPE_API = 1;
    public const TYPE_ACCOUNT = 2;

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function section(): ?BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_number', 'code');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function today_yesterday_percent($date, $from = null, $to = null, $type = 'day',$year=null,$percent=0)
    {

        $yesterday =   date('Y-m-d', strtotime('-1 ' . $type, strtotime($date))) ;
            if($type == 'week') {
            $dates = Carbon::now();
            $dates->setISODate($year, $date);
            $startWeek = $dates->startOfWeek()->format('Y-m-d');
            $endWeek = $dates->endOfWeek()->format('Y-m-d');
            $dates->setISODate($year, $date-1);
            $startWeek2 = $dates->startOfWeek()->format('Y-m-d');
            $endWeek2 = $dates->endOfWeek()->format('Y-m-d');
            $today_total = self::where('date', '>=', $startWeek)
                ->where('date', '<', $endWeek)
                ->where(function ($query) use($from,$to){
                    if(!empty($from) && !empty($to)) {
                        $query->where('operation_time', '>=', $from)
                        ->where('operation_time', '<=', $to);
                    }
                })
                ->sum('total');
                $yesterday_total =self::where('date', '>=', $startWeek2)
                ->where('date', '<', $endWeek2)
                ->where(function ($query) use ($from, $to) {
                    if(!empty($from) && !empty($to)) {
                        $query->where('operation_time', '>=', $from)
                        ->where('operation_time', '<=', $to);
                    }
                })
                ->sum('total');
                if($percent&&($yesterday_total == 0 || $yesterday_total==null)){
                    return 100;
                }
                if($percent){
                    return ($today_total / $yesterday_total)*100;
                }
                return  ($today_total -  $yesterday_total);

            }
             elseif($type == 'month') {

                $startMonth = $year.'-'.$date.'-01';
                $d = new DateTime($startMonth);
                $endMonth=$d->format('Y-m-t');

                $startMonth2 = $year.'-'.($date-1).'-01';
                $d2 = new DateTime($startMonth2);
                $endMonth2=$d2->format('Y-m-t');

                $today_total = self::whereBetween('date', [$startMonth, $endMonth])
                ->sum('total');

                $yesterday_total = self::whereBetween('date', [$startMonth2, $endMonth2])
                ->sum('total');

                if($percent && ($yesterday_total == 0 || $yesterday_total == null)) {
                    return $today_total;
                }

                return  $percent ? ($today_total / (($yesterday_total>0|| $yesterday_total!=null)?$yesterday_total:1)) * 100 : ($today_total -  $yesterday_total);

            } elseif ($type == 'year') {
                $startYear= $date.'-01-01';
                $endYear= $date.'-12-31';
                $startYear2= ($date-1).'-01-01';
                $endYear2= ($date-1).'-12-31';
                $today_total = self::whereBetween('date', [$startYear, $endYear])
                            ->sum('total');
                $yesterday_total = self::whereBetween('date', [$startYear2, $endYear2])
                ->sum('total');
                if($percent && ($yesterday_total == 0 || $yesterday_total == null)) {
                    return $today_total;
                }

                return  $percent ? ($today_total / (($yesterday_total>0|| $yesterday_total!=null)?$yesterday_total:1)) * 100 : ($today_total -  $yesterday_total);
            }
            else{
                $today_total = self::where('date', $date)
                ->sum('total') ;
                $yesterday_total = self::where('date', $yesterday)
                ->sum('total') ;

                        if($percent && ($yesterday_total == 0 || $yesterday_total == null)) {
                            return 100;
                        }

                return  $percent ? ($today_total / (($yesterday_total>0|| $yesterday_total!=null)?$yesterday_total:1)) * 100 : ($today_total -  $yesterday_total);
            }

    }


    public function doner_type()
    {

       $total = Link::where('phone' , $this->phone)->sum('total');
       $type = DonerType::where('from' , '<=' , $total)
                           ->where('to' , '>=' ,  $total )
                           ->first() ;
         if( $type )
         {
           return $type->name ;
         }else{
           return " " ;
         }

    }

    public function other_project( $project_id , $phone  )
    {


        if( !empty(  $project_id ) )
        {


            $data = Link::where('phone' , $phone  )
                ->where('project_number'  ,'!=' ,  $project_id )

              ->get(['id' , 'total']);
             if(  $data )
             {
                 return $data ;
             }else{
                 return "0" ;
             }

        }else{

            return null ;

        }



    }

}

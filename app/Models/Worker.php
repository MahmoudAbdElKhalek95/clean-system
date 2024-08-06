<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter ;


class Worker extends Model
{
    use HasFactory;

    protected $table = "workers";
    protected $guarded = [];

    protected $appends = ['status_name'] ;

    public function school()
    {
        return $this->belongsTo( School::class , 'school_id' , 'id') ;
    }

    public function project()
    {
        return $this->belongsTo( Contract::class , 'project_id' , 'id') ;
    }

    public function getStatusNameAttribute()
    {

        switch ($this->status) {
            case 'work':
               return "قيد العمل" ;
                break;

           case 'holiday':
               return " اجازه" ;
                break;    

            case 'not_deserve':
              return " لا يستحق" ;
              break;    
                           
            default:
                 return null ;
                break;
        }

    }


    public function getsalaryInArabic()
    {

      $digit = new NumberFormatter("ar", NumberFormatter::SPELLOUT);

      $salary    =   $this->salary  ;
      $arr       = explode('.'  , $salary ) ;    // change string to array using delimter

       if(   count( $arr  )  > 1  )
       {

          $real_salary = $arr[0] ;
          $halla_salary = $arr[1] ;
          $salary_arabic = $digit->format( $real_salary) . "  ريال  " . " و " . $digit->format( $halla_salary)  . " هلله "  ;

       }else{

          $salary_arabic = $digit->format( $this->salary ) .  "  ريال لا غير  "  ;

       }

         return   $salary_arabic ;

    }


}

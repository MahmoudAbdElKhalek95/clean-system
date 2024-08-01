<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doner extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "doners";
    protected $fillable = ['name', 'phone', 'doner_type_id', 'type','amounts'];

    public function donerType(){
        return $this->belongsTo(DonnerAmount::class,'phone','phone');
    }
    // public function donersNumber(){
    //     return $this->belongsTo(DonerType::class,'doner_type_id');
    // }
    // public function donersAmount(){
    //     return $this->belongsTo(DonerType::class,'doner_type_id');
    // }


     public function doner_type($total)
     {

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

}

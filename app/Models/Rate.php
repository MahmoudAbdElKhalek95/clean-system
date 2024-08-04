<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = "rates";
    protected $guarded = [] ;


    public function super()
    {
        return $this->belongsTo( User::class , 'super_id' , 'id') ;
    }

    public function manager()
    {
        return $this->belongsTo( User::class , 'manager_id' , 'id') ;
    }
    

    public function visit_details()
    {
        return $this->belongsTo( VisitDetail::class , 'visit_id' , 'id') ;
    }


  


}

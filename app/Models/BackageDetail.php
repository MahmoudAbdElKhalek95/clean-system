<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackageDetail extends Model
{
    use HasFactory;

    protected $table = "backage_details";
    protected $guarded = [] ;

    public function school()
    {
        return $this->belongsTo( School::class , 'school_id' , 'id') ;
    }

    public function backage()
    {
        return $this->belongsTo( Backage::class , 'backage_id' , 'id') ;
    }
}

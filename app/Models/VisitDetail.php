<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitDetail extends Model
{
    use HasFactory;

    protected $table = "visit_details";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo( User::class , 'user_id' , 'id') ;
    }

    public function visit()
    {
        return $this->belongsTo( Visit::class , 'visit_id' , 'id') ;
    }

    public function school()
    {
        return $this->belongsTo( School::class , 'school_id' , 'id') ;
    }
}

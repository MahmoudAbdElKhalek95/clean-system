<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $table = "workers";
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo( School::class , 'school_id' , 'id') ;
    }

    public function project()
    {
        return $this->belongsTo( Contract::class , 'project_id' , 'id') ;
    }
}

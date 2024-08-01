<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompainHistory extends Model
{
    use HasFactory;

    protected $guarded  = [] ;
    protected $table = "compain_histories";

    public function compain()
    {
        return $this->belongsTo(Compain::class , 'compain_id' , 'id') ;
        
    }

    public function marketing_project()
    {
        return $this->belongsTo(Project::class , 'marketing_project_id' , 'id') ;
        
    }

    
}

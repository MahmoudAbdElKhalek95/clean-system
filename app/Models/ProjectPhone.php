<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhone extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','category_id','phone','status'  ];

    protected $table = "project_phones";

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}

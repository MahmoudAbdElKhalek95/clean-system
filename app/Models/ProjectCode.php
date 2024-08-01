<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCode extends Model
{
    use HasFactory;
    protected $table="project_codes";
    protected $fillable = ['code','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Initiative extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'initiatives';
    protected $fillable = ['name', 'code', 'path_id','project_id','category_id','type','archive_id','show_in_statistics'];

    public function path()
    {
        return $this->belongsTo(Path::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'initiative_users');
    }
}

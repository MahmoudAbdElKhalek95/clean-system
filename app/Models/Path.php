<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Path extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'paths';
    protected $fillable = ['name'];
    public function users(){
        return $this->belongsToMany(User::class, 'path_users');
    }
    public function initiatives(){
        return $this->hasMany(Initiative::class, 'path_id');
    }
}

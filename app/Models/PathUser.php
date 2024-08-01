<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathUser extends Model
{
    use HasFactory;
    protected $table = 'path_users';

    protected $fillable = ['user_id','path_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function path(){
        return $this->belongsTo(Path::class);
    }
}

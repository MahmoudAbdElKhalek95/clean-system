<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetUser extends Model
{
    use HasFactory;

       protected $table = 'target_users';

    protected $fillable = ['user_id','target_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function target(){
        return $this->belongsTo(Target::class);
    }
}

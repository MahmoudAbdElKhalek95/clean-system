<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitiativeUser extends Model
{
    use HasFactory;

    protected $table = 'initiative_users';

    protected $fillable = ['user_id','initiative_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function initiative(){
        return $this->belongsTo(Initiative::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResendPhone extends Model
{
    use HasFactory;
    protected $table = "resend_phones";
    protected $fillable = ['project_id','phone'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}

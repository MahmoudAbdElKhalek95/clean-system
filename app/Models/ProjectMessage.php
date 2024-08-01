<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMessage extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','percent_id','percent','archieved','phone_numbers','sendding_numbers'];

    protected $table = "project_messages";

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function percent(){
        return $this->belongsTo(whatsappSetting::class);
    }
}

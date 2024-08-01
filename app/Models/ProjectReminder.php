<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReminder extends Model
{
    use HasFactory;
    protected $table = "project_reminders";
    protected $fillable = ['project_id','reminder_id'];

    public function reminder(){
        return $this->belongsTo(Reminder::class);
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
}

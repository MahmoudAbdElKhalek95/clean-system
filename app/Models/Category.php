<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['category_number','name','phone_id','ojects'];
    protected $table = "categories";
    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function phone(){
        return $this->belongsTo(WhatsappPhone::class,'phone_id');
    }
}

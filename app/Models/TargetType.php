<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetType extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "target_types";
    protected $fillable = ['name','value','status'];
    
}

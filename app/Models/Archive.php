<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "archives";
    protected $fillable = ['name','status','start','end','amount'];

}

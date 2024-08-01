<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendedPhone extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_code',
        'percent_id',
        'phone',
        'status',
        'date'
    ];
    
}


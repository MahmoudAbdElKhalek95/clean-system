<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = "contacts";
    protected $fillable = [
        'phone',
        'notes',
        'doner_id'
    ];

    public function doner()
    {
        return $this->belongsTo(Doner::class);
    }
}

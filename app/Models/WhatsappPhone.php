<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappPhone extends Model
{
    use HasFactory;
    protected $table = "whatsapp_phones";
    protected $fillable = ['name','listen_id','token_id' ];


}


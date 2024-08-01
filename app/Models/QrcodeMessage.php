<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrcodeMessage extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "qrcode_messages";

    protected $fillable = ["name","phone","serial_number","phone_id","status","send_at"];

    public function phoneSetting()
    {
        return $this->belongsTo(WhatsappPhone::class, 'phone_id');
    }
    
}

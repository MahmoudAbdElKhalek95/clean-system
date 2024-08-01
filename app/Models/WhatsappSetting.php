<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappSetting extends Model
{
    use HasFactory;
    protected $table = "whatsapp_settings";
    protected $fillable = ['status','category_id','percent','message','image','percent2','message2','status2','phone_id','last_send','type','details'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sendingTemplate()
    {
        return $this->belongsTo(SendingTemplate::class, 'message');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function phone()
    {
        return $this->belongsTo(WhatsappPhone::class, 'phone_id');
    }

}

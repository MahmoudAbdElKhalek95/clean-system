<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $fillable = ['day_number','message','category_id','phone_id'];
    protected $table = "reminders";

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function phone(){
        return $this->belongsTo(WhatsappPhone::class,'phone_id');
    }

}

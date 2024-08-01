<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonnerAmount extends Model
{
    use HasFactory;

    protected $table="donner_amounts";
    protected $fillable = ['phone', 'amount', 'total'];

    public function doner(){
        return $this->belongsTo(Doner::class,'phone','phone');
    }
}

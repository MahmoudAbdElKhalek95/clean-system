<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','type_id'];
    protected $table = "clients";


    public function type()
    {
        return $this->belongsTo(Type::class , 'type_id' , 'id') ;
    } 

  
}

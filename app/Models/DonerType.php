<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonerType extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "doner_types";

    public $appends = ['type_name'] ;

    protected $fillable = ['name','from','to' , 'link_from' , 'link_to' , 'type'];

    public function getTypeNameAttribute()
   {
      return $this->type == "money" ?  'مبالغ' : 'عمليات'  ;
   }

  
}

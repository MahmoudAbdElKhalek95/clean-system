<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="projects";
    protected $fillable = ['name','code','category_id','quantityInStock','price','totalSalesTarget','totalSalesDone','message','not_active','send_status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function getPercent()
    {
        if ($this->totalSalesTarget > 0) {
            $percent = ($this->totalSalesDone / $this->totalSalesTarget) * 100 ;
        } else {
            $percent = 0  ;
        }
        $percent = number_format($percent, 2) ;
        return $percent ;

    }
}

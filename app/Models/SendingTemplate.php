<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendingTemplate extends Model
{
    use HasFactory;

    protected $table = "sending_templates" ;
    protected $guarded =  [] ;
    protected $appends = ['image' , 'videos' ] ;


    public function project()
    {
        return  $this->belongsTo(Project::class, 'project_name', 'id') ;
    }

    public function getImageAttribute()
    {

        if(isset($this->photo)  && $this->photo != null) {
            return asset('storage/sending_templates/'.$this->photo) ;
        } else {

            return null ;
        }

    }

    public function getVideosAttribute()
    {

        if(isset($this->video)  && $this->video != null) {
            return asset('storage/sending_templates/'.$this->video) ;
        } else {

            return null ;
        }

    }
}

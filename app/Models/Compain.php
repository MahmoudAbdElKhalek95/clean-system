<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compain extends Model
{
    use HasFactory,SoftDeletes;

protected $fillable = ['sending_channel','name','code','amount' , 'targets' , 'target_type_id' ,'target_doner_type_id' , 'whatsapp_template' , 'category_id' , 'project_id' , 'marketing_project_id' , 'sending_way' ];

    protected $table = "compains";

 /*   public function project()
    {
        return $this->belongsTo(Project::class , 'project_id' , 'id') ;

    }
    */

    public function project()
    {

        if( !empty(  $this->project_id ) )
        {

            $project_id = json_decode(  $this->project_id ) ;

            $projects = Project::whereIn('id' , $project_id )->pluck('name')->toArray() ;

            if( !empty(   $projects ) )
            {
             $data  =  implode(',' ,   $projects ) ;
             return $data ;

            }else{
                 return  " " ;
            }

        }else{
            return null ;
         }

    }

    public function marketing_project()
    {

      return $this->belongsTo(Project::class,'marketing_project_id');

    }
    



    public function category()
    {
        if( !empty( $this->category_id ) )
       {


        $category_id = json_decode(  $this->category_id ) ;

        $Category = Category::whereIn('id' , $category_id )->pluck('name')->toArray() ;

        if( !empty(   $Category ) )
        {
            $data  =  implode(',' ,   $Category ) ;
            return $data ;
        }else{
             return  " " ;
        }
     }else{
        return null ;
     }


    }



    public function whatsapps()
    {
        return $this->belongsTo(SendingTemplate::class , 'whatsapp_template' , 'id') ;

    }

}

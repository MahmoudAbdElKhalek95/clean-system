<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    use HasFactory;
    protected $table = "share_links";
    protected $fillable = [ 'name' , 'project_id','type'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id') ;
    }

    public function getLink()
    {

        //  https://give.qb.org.sa/P/586/?r=empy0257

        $project_id = $this->project_id ;

        $user_code = auth()->user()->code ;
        if($this->type==2) {

            $link = 'https://give.qb.org.sa/g/'.$project_id.'/?r='.$user_code  ;
        } else {
            $link = 'https://give.qb.org.sa/P/'.$project_id.'/?r='.$user_code  ;

        }
        return $link ;


    }

}

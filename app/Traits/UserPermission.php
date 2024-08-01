<?php

namespace App\Traits;

use App\Models\User;

trait UserPermission
{
  public function userpermission(){
        if(auth()->user()->type==User::TYPE_CLIENT){
            flash(__('admin.messages.you_dont_have_permission'))->error();
            return back();
        }
    }
}

?>

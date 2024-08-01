<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    public static function getPermission($permission)
    {
        return self::getPermissions()[$permission] ?? '';
    }

    public static function getPermissions()
    {
        return [
            'roles_manage'       => __('roles.permissions.roles_manage'),
            'settings_manage'    => __('roles.permissions.settings_manage'),
            'user_questions_manage'       => __('roles.permissions.user_questions_manage'),
        ];
    }
}

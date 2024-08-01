<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait TimezoneFormat
{
    
    // protected function createdAt(): Attribute
    // {
    //     return Attribute::make(
    //             get: function ($value) {
    //             return Carbon::parse($value)->timezone('Africa/Cairo');
    //         }
    //     );
    // }
}

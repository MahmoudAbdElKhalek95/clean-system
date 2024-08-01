<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    use HasFactory;
    protected $table = 'tests';
    protected $fillable = ['image','active'];
    protected $appends = ['photo'];
    public $translatedAttributes = ['title'];

    public function getPhotoAttribute()
    {
        return array_key_exists('image', $this->attributes) ? ($this->attributes['image'] != null ? asset('storage/tests/' . $this->attributes['image']) : null) : null;

    }
}

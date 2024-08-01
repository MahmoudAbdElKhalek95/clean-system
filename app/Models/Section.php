<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="sections";
    protected $fillable = ['name','code','section_type'];
    const TYPE_CODE=1;
    const TYPE_PROJECT_ID=2;
    public function links(): ?HasMany
    {
        return $this->hasMany(Link::class);
    }
}

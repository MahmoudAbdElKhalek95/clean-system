<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $table = 'users';
    protected $fillable = [ 'name' ,'first_name','mid_name','last_name', 'phone', 'email',  'type','reset_code','password','code','vip','target_type_id','target_amount'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   // protected $appends = ['name'];

    public const TYPE_ADMIN = 1;

    public const TYPE_Supervisor = 2;
    public const TYPE_CLIENT = 2;


    public const TYPE_RESPONSIBLE = 3;

    public function links():?HasMany
    {
        return $this->hasMany(Link::class,'code');
    }

    public static function lastOperationDate($user_id)
    {
        return DB::table('links')->where('user_id',$user_id)->latest('id')->first();
    }
    public function paths()
    {
        return $this->belongsToMany(Path::class, 'path_users');
    }



    public function initiatives()
    {
        return $this->belongsToMany(Initiative::class, 'initiative_users');
    }
    public function targets()
    {
        return $this->belongsToMany(Target::class, 'target_users');
    }
    public function users()
    {
        return $this->belongsToMany(ClientUser::class, 'client_users','user_id','client_id');
    }
    public function clients()
    {
        return $this->belongsToMany(ClientUser::class, 'client_users','client_id','user_id');
    }

  /*  public function getNameAttribute()
    {
        return ($this->attributes['first_name'] ?? '' ).' '.($this->attributes['mid_name']??'').' '.($this->attributes['last_name']??'');
    }
        */
    public function targetType(){
        return $this->belongsTo(TargetType::class, 'target_type_id');
    }

}

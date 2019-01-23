<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password','provider','provider_id','photo','active'
    ];
    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function materials()
    {
        return $this->hasMany('App\Material');
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\PurchaseOrder');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
    * Check multiple roles or 1 role
    * @param array $roles
    */  
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name',$roles)->first();
    }
    /**
    * Check 1 role
    *@param string $role
    */

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name',$role)->first();
    }


    public function authorizeRoles($roles)
    {
        if(is_array($roles)){
            return $this->hasAnyRole($roles);
        }
        return $this->hasRole($roles);
    }
}

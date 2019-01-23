<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name','description'];
    protected $primaryKey = 'id';

    public $timestamps = true;

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialGroup extends Model
{
    protected $table = 'material_groups';
    protected $fillable = ['material_group_id','material_group'];
    protected $primaryKey = 'material_group_id';

    public $incrementing = false;
}

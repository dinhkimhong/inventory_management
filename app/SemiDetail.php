<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SemiDetail extends Model
{
    protected $table = 'semi_details';
    protected $fillable = ['semi_number','material_number','quantity_raw','price_raw','remark'];
    protected $primaryKey = 'number';

    public $timestamps = false;
}

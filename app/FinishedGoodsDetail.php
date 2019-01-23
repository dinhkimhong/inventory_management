<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedGoodsDetail extends Model
{
    protected $table = 'finished_goods_details';
    protected $fillable = ['finished_number','semi_number','semi_quantity','remark'];
    protected $primaryKey = 'number';

    public $timestamps = false;
}

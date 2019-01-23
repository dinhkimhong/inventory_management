<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishedGoods extends Model
{
    protected $table = 'finished_goods';
    protected $fillable = ['finished_description','created_by'];
    protected $primaryKey = 'finished_number';

    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $fillable = ['currency','currency_description'];
    protected $primaryKey = 'currency';

    public $incrementing = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    protected $table = 'sales_persons';
    protected $fillable = 'sales_name';
    protected $primaryKey = 'sales_id';
}

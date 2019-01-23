<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerClass extends Model
{
    protected $table = 'customer_classes';
    protected $fillable = ['customer_class','customer_class_description'];
    protected $primaryKey = 'customer_class';

    public $timestamps = false;
    public $incrementing = false;
}

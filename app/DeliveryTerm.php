<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryTerm extends Model
{
    protected $table = 'delivery_terms';
    protected $fillable = ['delivery_term','delivery_term_description'];
    protected $primaryKey = 'delivery_term';

    public $timestamps = false;
    public $incrementing = false;
}

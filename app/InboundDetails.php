<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InboundDetails extends Model
{
    protected $table = 'inbound_details';
    protected $fillable = ['material_number','inbound_number','receipt_quantity','batch_number','ordered_quantity'];
    protected $primaryKey = 'number';

    public $timestamps = false;
}

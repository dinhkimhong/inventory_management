<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InboundDetails extends Model
{
    protected $table = 'inbound_details';
    protected $fillable = ['inbound_number','pod_number','receipt_quantity','batch_number'];
    protected $primaryKey = 'number';

    public $timestamps = false;
}

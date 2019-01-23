<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    protected $table = 'inbounds';
    protected $fillable = ['created_by','receipt_date','po_number'];
    protected $primaryKey = 'inbound_number';

    public $timestamps = true;

}

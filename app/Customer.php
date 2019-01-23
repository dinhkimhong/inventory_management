<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['customer_name','billing_address','billing_province','ship_to_address','ship_to_province','country_code','tel','fax','website','contact','title','email','gst','gst_number','pst','pst_number','hst','hst_number','discount','sales_name','customer_class','created_by'];
    protected $primaryKey = 'customer_number';

    public $timestamps = true;
}

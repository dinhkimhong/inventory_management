<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = ['delivery_term','delivery_place','vendor_number','contact','email','total_freight_handling_cost','user_id','shipping_instruction','currency','delivery_date','payment_term'];
    protected $primaryKey = 'po_number';

    public $timestamps = true;
    protected $dates = ['delivery_date'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function purchase_order_details()
    {
    	return $this->hasMany('App\PurchaseOrderDetail');
    }
}

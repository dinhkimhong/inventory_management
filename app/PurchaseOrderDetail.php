<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_details';
    protected $fillable = ['po_number','material_number','quantity','import_duty','freight_handling_cost','unit_price','remark'];
    protected $primaryKey = 'number';

    public $timestamps = false;

    public function purchase_order()
    {
    	return $this->belongsToMany('App\PurchaseOrder');
    }
}

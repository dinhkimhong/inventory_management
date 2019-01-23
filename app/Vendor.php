<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    protected $table = 'vendors';
    protected $fillable = ['vendor_name','address_1','province_1','address_2','province_2','country_code','business_number','website','tel','fax','contact','title','email','position','created_by'];
    protected $primaryKey = 'vendor_number';

    public $timestamps = true;
}

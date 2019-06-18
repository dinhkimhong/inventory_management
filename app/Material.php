<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';
    protected $fillable = ['material_description', 
							'mfg_material_number', 
							'unit', 
							'material_group_id', 
							'manufacturer', 
							'weight', 
							'origin', 
							'gst', 
							'pst', 
							'hst', 
							'import_tax', 
							'export_tax', 
							'tarrif_code', 
							'discount',
							'planning', 
							'safety_stock', 
							'purchasing_price', 
							'selling_price', 
							'moving_price', 
							'currency', 
							'user_id'];
	protected $primaryKey='material_number';

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semi extends Model
{
    protected $table = 'semis';
    protected $fillable = ['semi_description','created_by'];
    protected $primaryKey = 'semi_number';

    public $timestamps = true;
}

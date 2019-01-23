<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'titles';
    protected $fillable = ['title','title_description'];
    protected $primaryKey = 'title';

    public $incrementing = false;
}

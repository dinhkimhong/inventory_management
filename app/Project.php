<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable=['project_number','created_by'];
    protected $primaryKey = 'project_number';

    public $incrementing = false;
    public $timestamps = true;
}

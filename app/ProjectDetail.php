<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $table = 'project_details';
    protected $fillable = ['project_number','finished_number','finished_quantity','remark'];
    protected $primaryKey = 'number';

    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newspaper extends Model
{
    protected $fillable = [
        'name','status','created_by','updated_by'
    ];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutOfHomeDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'out_of_home_id','type','duration','period','price','created_by','updated_by'
    ];
}

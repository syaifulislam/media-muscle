<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewspaperDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'newspaper_id','period_start','period_end','size','size','position','price','created_by','updated_by'
    ];

}

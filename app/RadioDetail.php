<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadioDetail extends Model
{
    protected $fillable = [
        'radio_id','period_start','period_end','type','time','price','created_by','updated_by'
    ];
}

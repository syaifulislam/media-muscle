<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelevisionDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'television_id','program_name','date','time_start','time_end','time','duration','position','premium_price','run_price','created_by','updated_by'
    ];
}

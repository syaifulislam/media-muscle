<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadioDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'radio_id','period_start','period_end','type','time','price','created_by','updated_by'
    ];

    public function radio(){
        return $this->belongsTo('App\Radio');
    }
}

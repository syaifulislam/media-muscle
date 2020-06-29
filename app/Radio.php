<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $fillable = [
        'name','city_id','region','status','created_by','updated_by'
    ];

    public function city(){
        return $this->belongsTo('App\City');
    }
}

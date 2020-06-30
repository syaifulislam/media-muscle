<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutOfHome extends Model
{
    protected $fillable = [
        'name','city_id','longitude','latitude','status','created_by','updated_by'
    ];

    public function city(){
        return $this->belongsTo('App\City');
    }
}

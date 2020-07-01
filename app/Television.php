<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Television extends Model
{
    protected $fillable = [
        'name','period_start','period_end','time','region','status','created_by','updated_by'
    ];

    public function television_detail(){
        return $this->hasMany('App\TelevisionDetail', 'television_detail_id');
    }
}

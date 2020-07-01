<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'television_detail_id',
        'radio_detail_id',
        'newspaper_detail_id',
        'out_of_home_detail_id',
        'item_name',
        'price',
        'period_start',
        'period_end',
        'additional_information',
    ];
}

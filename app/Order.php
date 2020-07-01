<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_number',
        'total_price',
        'status'
    ];

    public function order_detail(){
        return $this->hasMany('App\OrderDetail','order_id');
    }
}

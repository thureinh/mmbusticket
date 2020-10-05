<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = ['totalprice', 'code', 'buy_date'];
	public $timestamps = false;
    public function customerinfo()
    {
    	return $this->belongsTo('App\CustomerInfo', 'customer_info_id');
    }
}

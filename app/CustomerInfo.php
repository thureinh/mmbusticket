<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    protected $fillable = ['name', 'gender', 'email', 'phone_no', 'note', 'is_foreigner'];

    public function booking()
    {
    	return $this->hasOne('App\Booking', 'customer_info_id');
    }
}

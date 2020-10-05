<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $fillable = [
    	'license', 'photos'
    ];
    public function bustype()
    {
        return $this->belongsTo('App\BusType');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function seats()
    {
        return $this->hasMany('App\Seat');
    }
}

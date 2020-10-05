<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    //
    protected $fillable = [
    	'seat_number'
    ];
    public function bus()
    {
        return $this->belongsTo('App\Bus');
    }
    public function itineraries()
    {
    	return $this->belongsToMany('App\Itinerary')->withPivot('status');
    }
}

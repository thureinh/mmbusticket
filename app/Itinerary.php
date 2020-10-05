<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
	protected $fillable = ['departure', 'foreigner_allowrance', 'duration', 'price'];
	
    public function locations()
    {
        return $this->belongsToMany('App\Location')->withPivot('sequence_number', 'extra_info');
    }
    public function seats()
    {
    	return $this->belongsToMany('App\Seat')->withPivot('status');
    }    
}

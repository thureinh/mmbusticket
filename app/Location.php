<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
	use HasTranslations;    
    protected $fillable = ['name', 'image'];
    public $translatable = ['name'];

    public function itineraries()
    {
    	return $this->belongsToMany('App\Itinerary')->withPivot('sequence_number', 'extra_info');
    }	
}

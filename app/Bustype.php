<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bustype extends Model
{
	use HasTranslations;
    //
    public $translatable = ['name'];
    
    public function buses()
    {
    	return $this->hasMany('App\Bus');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
	use HasTranslations;    
    protected $fillable = ['name', 'image'];
    public $translatable = ['name'];
	
}

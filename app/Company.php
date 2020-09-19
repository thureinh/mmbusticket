<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable = ['name', 'logo'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function buses()
    {
    	return $this->hasMany('App\Bus');
    }
}

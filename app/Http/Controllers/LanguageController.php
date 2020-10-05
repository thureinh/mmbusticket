<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //
    public function index(Request $request, $locale)
    {
    	$request->session()->reflash();
    	if (! in_array($locale, ['en', 'mm'])) {
	        abort(400);
	    }
    	session(['lang' => $locale]);
    	return redirect()->back();
    }
}

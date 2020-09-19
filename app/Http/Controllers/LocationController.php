<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all()->map(function ($location) {
            $location->image = url('storage/' . $location->image);
            $location['url'] = url("/locations");
            return $location;
        });
        return view('backend.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customAttributes = [
            'location_name_eng' => 'Location name in English',
            'location_name_mm' => 'Location name in Myanmar',
        ];
        $request->validate([
            'image' => 'required|file|image',
            'location_name_eng' => 'required',
            'location_name_mm' => 'required',
        ], [], $customAttributes);

        $translations = [
           'en' => $request->input('location_name_eng'),
           'mm' => $request->input('location_name_mm')
        ];
        $location = new Location;
        $location->image = $request->file('image')->store('images/locations', 'public');
        $location->setTranslations('name', $translations);
        $location->save();
        return redirect()->route('locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
        return view('locations.show', compact($location));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $location->image = url('storage/' . $location->image);
        $location['url'] = url("/locations");
        return response()->json($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $customAttributes = [
            'location_name_eng' => 'Location name in English',
            'location_name_mm' => 'Location name in Myanmar',
        ];
        $validator = Validator::make($request->all(), [
            'location_name_eng' => 'required',
            'location_name_mm' => 'required',
        ], [], $customAttributes);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }   
        else{
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($location->image);
                $location->image = $request->file('image')->store('images/locations', 'public');  
            }
            $translations = [
               'en' => $request->input('location_name_eng'),
               'mm' => $request->input('location_name_mm')
            ];
            $location->setTranslations('name', $translations);
            $location->save();
            $locations = Location::all()->map(function ($location) {
                $location->image = url('storage/' . $location->image);
                $location['url'] = url("/locations");
                return $location;
            });
            return response()->json($locations);
        }     

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        Storage::disk('public')->delete($location->image);
        $location->delete();
        $locations = Location::all()->map(function ($location) {
            $location->image = url('storage/' . $location->image);
            $location['url'] = url("/locations");
            return $location;
        });
        return response()->json($locations);
    }
}

<?php

namespace App\Http\Controllers;

use App\Bus;
use App\BusType;
use App\Company;
use App\Seat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:company-manager');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buses = Auth::user()->company->buses->map(function($bus){
            $bus['url'] = url('buses');
            $bus->photos = collect(json_decode($bus->photos))->map(function($photo) { return url('storage/' . $photo); });
            $bus->bustype['en_name'] = $bus->bustype->translations['name']['en'];
            $bus->bustype['mm_name'] = $bus->bustype->translations['name']['mm'];
            $bus['nos'] = $bus->seats()->count(); 
            $bus->company;
            return $bus;
        });
        return view('backend.bus.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bustypes = BusType::all();
        return view('backend.bus.create', compact('bustypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'file|image',
            'license' => ['required', 'unique:buses,license'],//unique:table,column
            'bustype' => 'required',
            'nos' => 'required|min:1|max:100'
        ]);
        $seats = array();
        foreach (range(1, $request->input('nos')) as $number) 
        {
            $seat = ['seat_number' => $number];
            array_push($seats, $seat);
        }
        $image_arr = array();
        foreach($request->file('images') as $image)
        {
            array_push($image_arr, $image->store('images/buses', 'public'));
        }
        $bus = new Bus;
        $bus->photos = json_encode($image_arr);
        $bus->license = $request->input('license');
        $bus->company_id = Auth::user()->company->id;
        $bus->bustype_id = $request->input('bustype');
        $bus->save();
        $bus->seats()->createMany($seats);
        return redirect()->route('buses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        $bustypes = BusType::all();
        $bus['url'] = url('buses');
        $photos = collect(json_decode($bus->photos))->map(function($photo, $key) {
            $path_parts = pathinfo(Storage::disk('public')->url($photo));
            return [
                'path' => $photo,
                'name' => $path_parts['basename'],
                'type' => 'image/' . $path_parts['extension'],
                'size' => Storage::disk('public')->size($photo),
                'file' => url('storage/' . $photo),
            ];
        });
        $bus->bustype['en_name'] = $bus->bustype->translations['name']['en'];
        $bus->bustype['mm_name'] = $bus->bustype->translations['name']['mm'];
        $bus->company;
        return view('backend.bus.edit', compact('photos', 'bus', 'bustypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'license' => 'required',
            'bustype' => 'required',
            'nos' => 'required|min:1|max:100'
        ]);
        $nonewfiles = true;
        $removedall = false;

        $removed_items = json_decode($request->input('removed'));
        if(count($removed_items) === count(json_decode($bus->photos)))
            $removedall = true;

        $image_arr = array();
        if ($request->hasFile('images')) {
            foreach($request->file('images') as $image)
            {
                array_push($image_arr, $image->store('images/buses', 'public'));
            }
            $nonewfiles = false;        
        }
        if($nonewfiles && $removedall)
        {
            return redirect()->back()->withErrors(['images' => 'At least one file must be present.']);
        }
        else
        {
            if(!$removedall)
            {
                $removed_items_collection = collect($removed_items);       
                $left_items = collect(json_decode($bus->photos))->reject(function ($value) use ($removed_items_collection)
                {
                    return $removed_items_collection->contains($value);
                });
                foreach ($removed_items as $key => $photo) {
                    Storage::disk('public')->delete($photo);
                }
                $image_arr = array_merge($image_arr, $left_items->toArray());
            }
            Seat::where('bus_id', $bus->id)->delete();
            $seats = array();
            foreach (range(1, $request->input('nos')) as $number) 
            {
                $seat = ['seat_number' => $number];
                array_push($seats, $seat);
            }
            $bus->bustype_id = $request->input('bustype');
            $bus->license = $request->input('license');
            $bus->photos = json_encode($image_arr);
            $bus->save();
            $bus->seats()->createMany($seats);
            return redirect()->route('buses.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus)
    {
        $photos = json_decode($bus->photos);
        foreach ($photos as $key => $photo) {
            # code...
            Storage::disk('public')->delete($photo);
        }
        $bus->delete();

        $buses = Bus::all()->map(function($bus){
            $bus['url'] = url('buses');
            $bus->photos = collect(json_decode($bus->photos))->map(function($photo) { return url('storage/' . $photo); });
            $bus->bustype['en_name'] = $bus->bustype->translations['name']['en'];
            $bus->bustype['mm_name'] = $bus->bustype->translations['name']['mm'];
            $bus['nos'] = $bus->seats()->count(); 
            $bus->company;
            return $bus;
        });
        return response()->json($buses);
    }
}

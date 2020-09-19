<?php

namespace App\Http\Controllers;

use App\Bus;
use App\BusType;
use App\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buses = Bus::all()->map(function($bus){
            $bus['url'] = url('buses');
            $bus->photos = collect(json_decode($bus->photos))->map(function($photo) { return url('storage/' . $photo); });
            $bus->bustype['en_name'] = $bus->bustype->translations['name']['en'];
            $bus->bustype['mm_name'] = $bus->bustype->translations['name']['mm'];
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
        $companies = Company::all();

        return view('backend.bus.create', compact('bustypes', 'companies'));
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
            'company' => 'required',
            'bustype' => 'required'
        ]);
        $image_arr = array();
        foreach($request->file('images') as $image)
        {
            array_push($image_arr, $image->store('images/buses', 'public'));
        }
        $bus = new Bus;
        $bus->photos = json_encode($image_arr);
        $bus->license = $request->input('license');
        $bus->company_id = $request->input('company');
        $bus->bustype_id = $request->input('bustype');
        $bus->save();
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
        $companies = Company::all();
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
        return view('backend.bus.edit', compact('photos', 'bus', 'bustypes', 'companies'));
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
            'company' => 'required',
            'bustype' => 'required'
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
            $bus->company_id = $request->input('company');
            $bus->bustype_id = $request->input('bustype');
            $bus->license = $request->input('license');
            $bus->photos = json_encode($image_arr);
            $bus->save();
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
            $bus->company;
            return $bus;
        });
        return response()->json($buses);
    }
}

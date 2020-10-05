<?php

namespace App\Http\Controllers;

use App\Itinerary;
use App\Bus;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_seats = Auth::user()->company->buses->map->seats
        ->map(function($seat){
            return $seat->first()->id;
        });
        $filtered_itineraries = DB::table('itinerary_seat')
                       ->whereIn('seat_id', $users_seats)
                       ->pluck('itinerary_id');
        $user_itineraries = Itinerary::whereIn('id', $filtered_itineraries->toArray())->get();
        $itineraries = $user_itineraries->map(function ($itinerary){
            $itinerary->departure = preg_replace('/\s+/', 'T', $itinerary->departure);
            $itinerary->locations = $itinerary->locations->map(function($location){
                $location['sequence_number'] = $location->pivot->sequence_number;
                $location['english'] = $location->translations['name']['en'];
                $location['myanmar'] = $location->translations['name']['mm'];
                $location['extra_info'] = $location->pivot->extra_info;
                return $location;
            });
            $itinerary->seats = $itinerary->seats->map(function($seat){
                $seat['status'] = $seat->pivot->status;
                return $seat;
            });
            $itinerary['bus_license'] = $itinerary->seats->first()->bus->license;
            $itinerary['bus_image'] = asset('storage/' . collect(json_decode($itinerary->seats->first()->bus->photos))->first());
            return $itinerary; 
        });
        return view('backend.itinerary.index', compact('itineraries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buses = Auth::user()->company->buses->all();
        $locations = Location::all()->map(function ($location){
            $location->english = $location->translations['name']['en'];
            $location->myanmar = $location->translations['name']['mm'];
            $location->image = url('storage/' . $location->image);
            return $location;
        });
        return view('backend.itinerary.create', compact('buses', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'itineraries' => ['required', Rule::notIn('[]')],
            'duration' => 'required',
            'departure' => 'required',
            'license' => ['required', Rule::notIn(0)],
            'price' => ['required', 'min:0']
        ]);
        //
        if ($validator->fails()) {
            $err = json_encode($validator->errors());
            return back()->withErrors($err);
        } 
        $itinerary = new Itinerary;
        $itinerary->departure = $request->input('departure');
        $itinerary->duration = $request->input('duration');
        $itinerary->foreigner_allowrance = $request->input('foreigner_allowrance') === 'true' ? true : false;
        $itinerary->price = $request->input('price');
        $itinerary->save();
        $location_arr = json_decode($request->input('itineraries'));
        foreach ($location_arr as $key => $value) {
            # code...
            $itinerary->locations()->attach($value->id, ['sequence_number' => $value->index + 1, 
                'extra_info' => isset($value->extra) ? $value->extra : null]);
        }
        $bus = Bus::find($request->input('license'));
        foreach ($bus->seats->toArray() as $key => $seat) {
            # code...
            $itinerary->seats()->attach($seat['id'], ['status' => 'available']);
        }
        return redirect()->route('itineraries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function show(Itinerary $itinerary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function edit(Itinerary $itinerary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Itinerary $itinerary)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use HylianShield\KeyGenerator\KeyGenerator;
use HylianShield\NumberGenerator\NumberGenerator;
use HylianShield\Encoding\Base32CrockfordEncoder;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $locations = Location::all();
        return view('frontend.index', compact('locations'));
    }
    public function search(Request $request)
    {
        $request->validate([
            'leavingfrom' => 'required',
            'goingto' => 'required',
            'date' => 'required',
            'noseats' => 'required',
            'nationality' => 'required'
        ]);
        $locale = session('lang', 'en');
        $leaving = $request->input('leavingfrom');
        $going = $request->input('goingto');
        $date = explode('-', $request->input('date'));
        $correct_dateformat = $date[2] . '-' . $date[1] . '-' . $date[0];
        $seat_num = $request->input('noseats');
        $nationality = Str::lower($request->input('nationality'));
        $leaving_location_id = \App\Location::find($leaving)->id;
        $going_location_id = \App\Location::find($going)->id;
        $start_itineraries = DB::table('itinerary_location')
        ->where('sequence_number', 1)
        ->where('location_id', $leaving_location_id)
        ->pluck('itinerary_id');
        $end_itineraries = DB::table('itinerary_location')
        ->whereIn('itinerary_id', $start_itineraries->toArray())
        ->where('sequence_number', '>', 1)
        ->where('location_id', $going_location_id)
        ->pluck('itinerary_id');
        $filteredByDate = \App\Itinerary::whereIn('id', $end_itineraries->toArray())
                ->whereDate('departure', $correct_dateformat)
                ->get();
        $final_results = $filteredByDate->filter(function ($element) use ($seat_num) {
            $count = $element->seats->filter(function ($seat){
                return $seat->pivot->status === 'available';
            })->count();
            return $seat_num <= $count;
        });
        if($nationality !== 'myanmar')
            $final_results = $final_results->filter(function ($element) {
                return $element->foreigner_allowrance === 1;
            });
        $pre = $request->all();
        return redirect()->route('detailSearch')->with('data', compact('final_results', 'pre'));
    }
    public function detailSearch(Request $request)
    {
        $locations = Location::all();
        $bustypes = \App\BusType::all();
        $request->session()->reflash();
        $value = $request->session()->get('data', []);
        $final_results = $value['final_results'];
        $pre = $value['pre'];
        return view('frontend.search', compact('final_results', 'pre', 'locations', 'bustypes'));
    }
    public function itineraryDetail(Request $request, $id)
    {
        $is_api = $request->query('api', 'false');
        $itinerary = \App\Itinerary::find($id);
        if(filter_var($is_api, FILTER_VALIDATE_BOOLEAN)){
            return response()->json([
                'locations' => $itinerary->locations->map(function($location){$location->location_name=$location->translations['name'][session('lang','en')];return $location;})->sortBy(function($location){return $location->pivot->sequence_number;}),
                'itinerary' => $itinerary->toArray(),
                'company' => $itinerary->seats->first()->bus->company
            ]);
        }
        else{
            return view('frontend.seat', compact('itinerary'));
        }
    }
    public function customerform(Request $request)
    {
        return view('frontend.custinfo');
    }
    public function book(Request $request)
    {
        $cart = json_decode($request->input('cart'));
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'nationality' => [
                'required',
                function ($attribute, $value, $fail) use ($cart) {
                    $itinerary = \App\Itinerary::find($cart->itinerary_id);
                    if($itinerary->foreigner_allowrance === 0)
                    {
                        if(Str::lower($value) !== 'myanmar')
                            $fail('This itinerary doesn\'t allow foreigners');
                    }
                }]
        ]);
        //
        if ($validator->fails()) {
            $err = json_encode($validator->errors());
            return back()->withErrors($err);
        }        
        $custinfo = new \App\CustomerInfo;
        $custinfo->name = $request->input('name');
        $custinfo->email = $request->input('email');
        $custinfo->phone_no = $request->input('phone');
        $custinfo->is_foreigner = Str::lower($request->input('nationality')) === 'foreigner' ? true : false;
        $custinfo->note = $request->input('note', "");
        $custinfo->gender = $request->input('gender');
                //voucher number
        $generator = new KeyGenerator(
            new NumberGenerator(),
            new Base32CrockfordEncoder()
        );
        $custinfo->save();
        $booking = $custinfo->booking()->create([
            'totalprice' => \App\Itinerary::find($cart->itinerary_id)->price * count($cart->seats),
            'code' => $generator->generateKey(4),
            'buy_date' => now()
        ]);
        foreach ($cart->seats as $seat_number) {
            $bus_id = \App\Itinerary::find($cart->itinerary_id)->seats->first()->bus->id;
            $seat_id = \App\Seat::where('seat_number', $seat_number)
                        ->where('bus_id', $bus_id)
                        ->first()->id;
            # code...
            $iseat_id = DB::table('itinerary_seat')
                        ->where('itinerary_id', $cart->itinerary_id)
                        ->where('seat_id', $seat_id)
                        ->update([
                            'booking_id' => $booking->id,
                            'status' => 'unavailable'
                        ]);
        }
        Mail::to($request->input('email'))
            ->locale(Str::lower($request->input('nationality')) === 'foreigner' ? 'en' : 'mm')
            ->send(new \App\Mail\TicketSent(
                $booking, 
                \App\Itinerary::find($cart->itinerary_id), 
                $cart->seats
            ));

        return back()->with('status', 'Successfully Booked!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Source\SourceItinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function get(Request $request)
    {
        if(!$request->sailing_id) {
            return false;
        }
        if($request->source) {
            $itins = SourceItinerary::itineraryForMap($request->sailing_id);
        } else {
            $itins = Itinerary::itineraryForMap($request->sailing_id);
        }
        return $itins;
    }
}

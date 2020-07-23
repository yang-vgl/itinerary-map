<?php

namespace App\Http\Controllers;

use App\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function get(Request $request)
    {
        if(!$request->sailing_id) {
            return false;
        }
        $itins = Itinerary::itineraryForMap($request->sailing_id);
        return $itins;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Sailing;
use App\Models\Source\SourceSailing;

class SailingsController extends Controller
{
    public function get()
    {
        $internal_sailings = Sailing::whereHas('trip', function ($query) {
            return $query->where('name', '!=', null);
        })
        ->with('trip')
        ->where('departure_date', '>', now())
            ->limit(5000)
            ->get()
            ->random(100);

        $external_sailings = SourceSailing::whereHas('ports', function ($query) {
            return $query->where('lat', '!=', null);
        })
        ->where('departure', '>', now())
            ->limit(5000)
            ->get()
            ->random(100);

        $data = [];

        foreach ($internal_sailings as $sailing) {
            $data['internal_sailings'][] = [
                'id' => $sailing->id,
                'name' => $sailing->trip ?  $sailing->trip->name : '',
                'departure' => $sailing->departure_date->toDateString(),
                'arrival' => $sailing->arrival_date->toDateString()
            ];
        }

        foreach ($external_sailings as $sailing) {
            $data['external_sailings'][] = [
                'id' => $sailing->id,
                'source' => $sailing->source,
                'name' =>$sailing->name,
                'departure' => $sailing->departure->toDateString(),
                'arrival' => $sailing->departure->toDateString()
            ];
        }

        $data = json_decode(json_encode($data, JSON_INVALID_UTF8_IGNORE), true);

        return $data;
    }
}

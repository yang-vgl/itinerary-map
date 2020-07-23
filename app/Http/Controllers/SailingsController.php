<?php

namespace App\Http\Controllers;

use App\Sailing;

class SailingsController extends Controller
{
    public function get()
    {
        $sailings = Sailing::with('trip')
        ->where('departure_date', '>', now())
            ->limit(100)
            ->get();
        $data = [];
        foreach ($sailings as $sailing) {
            $data[] = [
                'id' => $sailing->id,
                'name' => $sailing->trip ?  $sailing->trip->name : '',
            ];
        }
        return $data;
    }
}

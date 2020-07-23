<?php

namespace App\Models\Source;

use Illuminate\Database\Eloquent\Model;

class SourceItinerary extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sailing()
    {
        return $this->belongsTo(SourceSailing::class, 'sailing_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function port()
    {
        return $this->belongsTo(SourcePort::class, 'port_id');
    }

    public static function itineraryForMap($sailing_id)
    {

        $sailing = SourceSailing::find($sailing_id);
        if(!$sailing) {
            return [];
        }
        $itins = SourceItinerary::with('port')
        ->where('sailing_id', $sailing_id)->get();


        $data =  array_map(function($val) {
            return [
                'day' => $val['cday'] ?? '',
                'port_id' => $val['port_id'] ?? '',
                'port_name' =>  isset($val['port']) ? $val['port']['name'] : '',
                'gps' =>  isset($val['port']) ? [$val['port']['lng'], $val['port']['lat']] : '',
            ];
        }, $itins->toArray());
        $format = [];
        foreach($data as $key => $val) {
            $format[$key] = $val;
            if($key < 1) {
                continue;
            }
            if($data[$key]['port_name'] == $data[$key - 1]['port_name']) {
                $arr = is_array($format[$key-1]['day']) ? $format[$key-1]['day'] : [$format[$key-1]['day']];
                array_push($arr, $data[$key]['day']);
                $format[$key]['day'] = $arr;
                unset($format[$key - 1]);
            }
        }
        foreach($format as $key => $val) {
            if(is_array($format[$key]['day'])) {
                $days = current($format[$key]['day']).'-'.end($format[$key]['day']);
                $format[$key]['day'] = $days;
            }
        }
        return $format;
    }


}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Itinerary Model
 */
class Itinerary extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'source_itineraries';


    public $belongsTo = [
        'sailing' => 'Cruisewatch\Acquisition\Models\Sailing',
        'port' => 'Cruisewatch\Acquisition\Models\Port',
    ];

    public static function itineraryForMap($sailing_id)
    {

        $sailing = Sailing::find($sailing_id);
        if(!$sailing) {
            return [];
        }
        $data =  array_map(function($val) {
            return [
                'day' => $val['day'] ?? '',
                'label' =>  isset($val['port_id']) ? Port::find($val['port_id'])->name : ($val['label'] ?? ''),
                'port_id' => $val['port_id'] ?? '',
                'port_name' =>  isset($val['port_id']) ? Port::find($val['port_id'])->name : '',
                'country' =>  isset($val['port_id']) ?  isset(Port::find($val['port_id'])->country->name) ? Port::find($val['port_id'])->country->name : ''  : '',
                'gps' => isset($val['geo']) ? array_reverse(explode(',', $val['geo'])) :  '',
            ];
        }, json_decode($sailing->itinerary, true));
        $format = [];
        foreach($data as $key => $val) {
            $format[$key] = $val;
            if($key < 1) {
                continue;
            }
            if($data[$key]['label'] == $data[$key - 1]['label']) {
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

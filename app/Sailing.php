<?php namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Sailing Model
 */
class Sailing extends Model
{

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'pim_sailings';

    /**
     * @var array
     */
    protected $jsonable = [
        'itinerary'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'departure_date',
        'arrival_date',
    ];

    /**
     * @var array
     */
    public $belongsTo = [
        'trip' => 'App\Trip',
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'sailings' => ['\Cruisewatch\ProductManager\Models\Region', 'table' => 'cms_region_sailings'],
    ];

    public function trip()
    {
        return $this->hasOne('App\Trip', 'id', 'trip_id');
    }
    /**
     * @param $query
     * @param Carbon|null $starting_from
     * @return mixed
     */
    public function scopeInFuture($query, Carbon $starting_from=null)
    {
        if (empty($starting_from))
            $starting_from = now();

        return $query->where('departure_date', '>=', $starting_from);
    }


    /**
     * @param $query
     * @param Carbon|null $leaving_before
     * @return mixed
     */
    public function scopeInPast($query, Carbon $leaving_before=null)
    {
        if (empty($leaving_before))
            $leaving_before = now();

        return $query->where('departure_date', '<', $leaving_before);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrent($query)
    {
        $now = now();

        return $query->where('departure_date', '<', $now)
                ->where('arrival_date', '>', $now);
    }


    /**
     * @return string
     */
    public function getTypeName()
    {
        return 'sailings';
    }


    /**
     * @param Sailing $sailing
     */
    public static function asFormatedArray(Sailing $sailing, string $cabin_type)
    {
        $price = $sailing['price']->forCabintype($cabin_type);

        return [
            'id' => $sailing['id'],
            'name' => $sailing['trip']['name'],
            'slug' => $sailing['trip']['slug'],
            'ship' => [
                'id' => $sailing['ship']['id'],
                'name' => $sailing['ship']['name'],
                'barometer' => [
                    'value' => $sailing['ship']['barometer']['value'],
                    'label' => $sailing['ship']['barometer']['label'],
                ],
            ],
            'cruiseline' => [
                'id' => $sailing['cruiseline']['id'],
                'name' => $sailing['cruiseline']['name'],
            ],
            'price' => [
                'total' => $price['current'],
                'per_night' => $price['per_night'],
                'reduction' => $price['change_abs'] ?? 0,
                'barometer' => [
                    'value' => $price['barometer']['value'] ?? 0,
                    'label' => $price['barometer']['label'] ?? '',
                ],
            ],
            'departure' => [
                'date' => $sailing['departure_date'],
                'port_id' => $sailing['departure_port']['id'],
                'port_name' => $sailing['departure_port']['name'],
            ],
            'arrival' => [
                'date' => $sailing['arrival_date'],
                'port_id' => $sailing['arrival_port']['id'],
                'port_name' => $sailing['arrival_port']['name'],
            ],
        ];
    }
}

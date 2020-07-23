<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Port Model
 */
class Port extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pim_ports';

    /**
     * @var array
     */
    public $jsonable = [
        'metas', 'description_extended',
        'cover_image',
        'gallery_images',
        'ratings', 'reviews', 'external_apis'
    ];

    public $nullable = [
        'title', 'intro', 'description_short', 'description_long'
    ];

    /**
     * @var array
     */
    protected $image_fields = [
        'cover_image', 'gallery_images'
    ];

    /**
     * @var array
     */
    public $belongsTo = [
        'country' => ['Cruisewatch\Pim\Models\Country', 'key' => 'country_id'],
    ];

    /**
     * @var array
     */
    public $hasMany = [
        'departures' => ['App\Sailing', 'key' => 'departure_port_id', 'otherKey' => 'id'],
        'arrivals' => ['App\Sailing', 'key' => 'arrival_port_id', 'otherKey' => 'id'],
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'regions' => ['\Cruisewatch\Pim\Models\Region', 'table' => 'cms_port_regions'],
    ];




    /**
     * @param $query
     * @param $country_id
     * @return mixed
     */
    public function scopeInCountry($query, $country_id)
    {
        return $query
                ->leftJoin('countries', 'countries.id', 'country_id')
                ->where(function($query) use ($country_id) {
                    $query->where('countries.id', $country_id)
                        ->orWhere('countries.parent_id', $country_id);
                });
    }
}

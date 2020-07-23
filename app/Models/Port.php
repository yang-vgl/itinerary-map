<?php namespace App\Models;

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

   public function country() {
       return $this->belongsTo('App\Models\Country', 'country_id', 'id');
   }

}

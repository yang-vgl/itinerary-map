<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Trip Model
 */
class Trip extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pim_trips';

    /**
     * @var array
     */
    public $jsonable = [
        'metas', 'description_extended',
        'cover_image',
        'gallery_images',
    ];

    public $belongsTo = [
        'cruiseline' => 'Cruisewatch\Pim\Models\Cruiseline',
        'ship' => 'Cruisewatch\Pim\Models\Ship',
    ];

    public $hasMany = [
        'sailings' => 'App\Models\Sailing'
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

}

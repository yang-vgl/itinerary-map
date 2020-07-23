<?php

namespace App\Models\Source;

use Illuminate\Database\Eloquent\Model;

class SourcePort extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function itineraries()
    {
        return $this->belongsToMany(SourceItinerary::class, 'source_itineraries', 'port_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function sailings()
    {
        return $this->hasManyThrough(SourceSailing::class, SourceItinerary::class, 'port_id');
    }
}

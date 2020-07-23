<?php

namespace App\Models\Source;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SourceSailing extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'departure', 'arrival',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cruiseline()
    {
        return $this->belongsTo(SourceCruiseline::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ship()
    {
        return $this->belongsTo(SourceShip::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ports()
    {
        return $this->hasManyThrough(SourcePort::class, SourceItinerary::class, 'sailing_id', 'id', 'id', 'port_id');
    }


    /**
     *
     */
    public function itins()
    {
        return $this->hasMany(SourceItinerary::class, 'sailing_id', 'id')
                ->orderBy('cday')
                ->orderBy('time_in')
                ->orderBy('time_out');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(SourcePrice::class, 'sailing_id')->orderBy('updated_at', 'desc');
    }


    /**
     * @param Carbon|null $date
     * @return $this
     */
    public function updateAcquisitionDate(Carbon $date=null)
    {
        $this->setAttribute('acquisition_at', $date ?: Carbon::now());

        return $this;
    }
}

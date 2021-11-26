<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLabs extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'glabs';

    protected $fillable = [
        'station_id',
        'access_token'
    ];

    protected $hidden = [
        'access_token'
    ];

    public function station()
    {
        return $this->belongsTo(ObservationsStation::class);
    }

    public function topups()
    {
        return $this
            ->hasMany(GLabsLoad::class, 'glabs_id', 'id');
    }
}

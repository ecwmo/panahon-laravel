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
        'access_token',
        'mobile_number',
    ];

    protected $hidden = [
        'access_token'
    ];

    public function station()
    {
        return $this->belongsTo(ObservationsStation::class, 'mobile_number', 'mobile_number');
    }

    public function topups()
    {
        return $this
            ->hasMany(GLabsLoad::class, 'glabs_id', 'id');
    }
}

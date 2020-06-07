<?php

namespace App\Models\Car;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Enter
 *
 * @package App\Models
 * @mixin Builder
 */
class Enter extends Model
{
    protected $table = 'cars_enters';

    protected $fillable = [
        'car_id',
        'gate_id',
        'has_access',
    ];

    public function car()
    {
        return $this->hasOne('App\Models\Car','id', 'car_id');
    }

    public function gate()
    {
        return $this->hasOne('App\Models\Gate','id','gate_id');
    }

}

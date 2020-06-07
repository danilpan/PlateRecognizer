<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class Gate
 *
 * @package App\Models
 * @mixin Builder
 */
class Gate extends Model
{
    protected $fillable = ['name', 'office_id', 'client_hash'];

    public function cars()
    {
        return $this->belongsToMany('App\Models\Car')->withPivot('has_access');
    }

    public function office()
    {
        return $this->belongsTo('App\Models\Office');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 *
 * @package App\Models
 * @mixin Builder
 */
class Office extends Model
{
    protected $fillable = ['full_address', 'company_id'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function gates()
    {
        return $this->hasMany('App\Models\Gate');
    }
}

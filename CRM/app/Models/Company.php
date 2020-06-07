<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @package App\Models
 * @mixin Builder
 */
class Company extends Model
{
    protected $fillable = [
        'official_name',
        'short_name',
    ];

    public function offices()
    {
        return $this->hasMany('App\Models\Office', 'company_id', 'id')->orderBy('id');
    }
}

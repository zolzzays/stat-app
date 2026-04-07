<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergySale extends Model
{
    protected $fillable = [
        'power_plant_id',
        'org_id',
        'year',
        'month',
        'product_name',
        'unit_name',
        'before_month',
        'before_sal',
        'this_month',
        'this_sal',
        'year_usage',
        'year_sal',
        'this_musage',
        'this_msal',
    ];

    public function powerPlant()
    {
        return $this->belongsTo(PowerPlant::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'org_id');
    }
}

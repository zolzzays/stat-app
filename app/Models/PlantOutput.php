<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantOutput extends Model
{
    protected $table = 'plant_output'; // Энд таны migration-д үүсгэсэн table нэрийг бичнэ
    protected $fillable = [
        'power_plant_id',
        'org_id',
        'year',
        'month',
        'product_name',
        'unit_name',
        'before_month',
        'this_month',
        'year_usage',
        'this_musage',
    ];

    // PowerPlant-тэй холболт
    public function powerPlant()
    {
        return $this->belongsTo(PowerPlant::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'org_id');
    }
}



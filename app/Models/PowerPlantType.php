<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerPlantType extends Model
{
    protected $fillable = ['t_name'];

    // power_plants-тай холбоо
    public function plants()
    {
        return $this->hasMany(PowerPlant::class, 'type_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerPlant extends Model
{
    protected $fillable = ['plant_name', 'type_id', 'org_id', 'reg_type_id'];

    // Relationship: PowerPlantType-тэй холбох
    public function type()
    {
        return $this->belongsTo(PowerPlantType::class, 'type_id');
    }

    public function outputs()
    {
        return $this->hasMany(PlantOutput::class);
    }

    /**
     * Станцад харьяалагдах хэрэглэгчид
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'org_id');
    }

    public function regType()
    {
        return $this->belongsTo(\App\Models\RegType::class, 'reg_type_id');
    }
}


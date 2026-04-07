<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrCount extends Model
{
    protected $table = 'hr_count';

    protected $fillable = [
        'power_plant_id',
        'org_id',
        'year',
        'month',
        'emp_male',
        'emp_female',
        'work_male',
        'work_female',
    ];

    public function powerPlant()
    {
        return $this->belongsTo(PowerPlant::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name', 'date', 'semester', 'academic_year', 'department', 'service',
        'age', 'sex', 'municipality', 'client_category', 'cc1', 'cc2', 'cc3',
        'expectations_0', 'expectations_1', 'expectations_2', 'expectations_3',
        'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8','service_id'
    ];

    // Define the relationship to the Service model
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');  // 'service_id' is the foreign key
    }
    
}

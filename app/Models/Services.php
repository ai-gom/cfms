<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'services_name',
        'services_type',
    ];

     // Define the relationship to the Form model
     public function forms()
     {
         return $this->hasMany(Form::class);
     }
}

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
        'user_id', // Include `user_id` in the fillable array

    ];

     // Define the relationship to the Form model
     public function forms()
     {
         return $this->hasMany(Form::class);
     }
     public function user()
{
    return $this->belongsTo(User::class);
}

}

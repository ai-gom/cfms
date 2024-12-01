<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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

// Method to generate QR code as PNG
public function generateQrCode()
{
    $url = url('/form?selected_service=' . $this->id);

    $options = new QROptions([
        'version'      => 5,
        'outputType'   => QRCode::OUTPUT_IMAGE_PNG, // PNG output
        'eccLevel'     => QRCode::ECC_L,
        'scale'        => 5,
    ]);

    return (new QRCode($options))->render($url);
}
}

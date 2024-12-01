<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QRCodeController extends Controller
{
    public function generateAndDownload($id)
    {
        // Fetch the service by ID
        $service = \App\Models\Services::findOrFail($id);

        // URL to encode in the QR code
        $url = url('/form?selected_service=' . $service->id);

        // Configure QR Code options
        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG, // Use SVG format
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 10,
        ]);

        // Generate QR code as SVG
        $svg = (new QRCode($options))->render($url);

        // Convert SVG to PNG using an online service (as a fallback if no extensions are available)
        $pngFilePath = 'qrcodes/qrcode-' . $service->id . '.png';

        // Save the SVG content
        $tempSvgPath = storage_path('app/temp-' . $service->id . '.svg');
        file_put_contents($tempSvgPath, $svg);

        // Convert SVG to PNG locally using Imagick (preferred if available)
        if (class_exists(\Imagick::class)) {
            $imagick = new \Imagick();
            $imagick->readImage($tempSvgPath);
            $imagick->setImageFormat('png');
            $pngContent = $imagick->getImageBlob();
            $imagick->clear();
            $imagick->destroy();

            // Save PNG content to storage
            Storage::put($pngFilePath, $pngContent);
        } else {
            // If no Imagick, fallback to download the SVG directly
            return response($svg, 200, [
                'Content-Type' => 'image/svg+xml',
                'Content-Disposition' => 'attachment; filename="qrcode-' . $service->id . '.svg"',
            ]);
        }

        // Delete the temporary SVG file
        unlink($tempSvgPath);

        // Return the PNG as a downloadable response
        return response()->download(storage_path('app/' . $pngFilePath))->deleteFileAfterSend(true);
    }
}

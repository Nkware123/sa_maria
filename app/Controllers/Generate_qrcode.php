<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Generate_qrcode extends BaseController
{
    // ... vos autres méthodes ...

    public function generate_qr_code()
    {
        $data = 'https://www.example.com';
        
        // Configuration du QR code
        $options = new QROptions([
            'version'      => 5,
            'outputType'   => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'     => QRCode::ECC_L,
            'scale'        => 10,
            'imageBase64'  => false,
        ]);
        
        $qrCode = (new QRCode($options))->render($data);
        
        // Retourner l'image PNG directement
        return $this->response
                    ->setContentType('image/png')
                    ->setBody($qrCode);
    }
}
<?php

namespace App\Services;

use App\Models\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RequestLogger
{
    public static function logRequestToNpr(int $gateId, array $responseFromNrp, UploadedFile $image)
    {
        $request = new Request();
        $request->setGateId($gateId);
        $request->setResponseFromNrp(json_encode($responseFromNrp, true));
        $request->setRequestImageUrl($image);
        $request->save();
    }
}

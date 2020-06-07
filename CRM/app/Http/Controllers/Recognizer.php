<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Car\Enter;
use App\Models\Gate;
use App\Services\Recognition;
use App\Services\RequestLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class Recognizer extends Controller
{
    public function recognizeAction(Request $request)
    {
        try {
            $hash  = $request->header('hash');
            $image = $request->file('car_image');

            $gate   = $this->getGateByClientHash($hash);
            $number = $this->getNumber($image->get());

            RequestLogger::logRequestToNpr($gate->id, $number, $image);

            if ($this->isAvailableToEnter($number['plateNumber'], $gate->id)) {
                return 'Success';
            }
        } catch (Exception $exception) {
            Log::error(print_r([
                'Message' => $exception->getMessage(),
                'Trace'   => $exception->getTraceAsString(),
            ], true));
        }

        return 'Error';
    }

    private function getNumber($image)
    {
        $recognizer = new Recognition();
        $recognizer->setImage($image);

        return $recognizer->getNumber();
    }

    public function isAvailableToEnter($number, int $gateId)
    {
        $car             = $this->findCarOrFail($number);
        $hasAccessToGate = $car->hasAccessToGate($gateId);
        $this->logEnteringCarToGate($car->id, $hasAccessToGate, $gateId);

        return $hasAccessToGate;
    }

    private function logEnteringCarToGate($carId, $hasEntered, $gateId)
    {
        $enter = new Enter();
        $enter->setAttribute('car_id', $carId);
        $enter->setAttribute('gate_id', $gateId);
        $enter->setAttribute('has_entered', $hasEntered);
        $enter->save();
    }

    /**
     * @param $plateNumber
     *
     * @return Car
     */
    private function findCarOrFail($plateNumber)
    {
        return Car::query()->where('plate_number', '=', $plateNumber)->firstOrFail();
    }

    private function getGateByClientHash(string $hash): Gate
    {
        return Gate::query()->where('client_hash', '=', $hash)->firstOrFail();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class Car
 *
 * @package App\Models
 * @mixin Builder
 */
class Car extends Model
{
    protected $fillable = ['plate_number'];

    public function gates()
    {
        return $this->belongsToMany('App\Models\Gate')->withPivot('has_access');
    }

    public function getGateIds()
    {
        $ids = [];
        foreach ($this->gates as $gate) {
            $ids[] = $gate->id;
        }

        return $ids;
    }

    public function updateGates($gates)
    {
        if ($this->isGatesEmpty($gates)) {
            $this->clearGatesOfCar();
        } else {
            $this->updateGatesFromRequest($gates);
            $this->updateGatesOfCar($gates);
        }
    }

    private function clearGatesOfCar()
    {
        if ($this->gates) {
            foreach ($this->gates as $gate) {
                $this->gates()->updateExistingPivot($gate->id, ['has_access' => '0'], true);
            }
        }
    }

    private function updateGatesFromRequest(array $gates)
    {
        $gateIds = $this->getGateIds();

        foreach ($gates as $gate_id) {
            if (in_array($gate_id, $gateIds)) {
                $this->gates()->updateExistingPivot($gate_id, ['has_access' => 1]);
            } else {
                $this->gates()->attach($gate_id, ['has_access' => 1]);
            }
        }
    }

    private function updateGatesOfCar(array $gates)
    {
        $gateIds = $this->getGateIds();
        foreach ($gateIds as $gate_id) {
            if (!in_array($gate_id, $gates)) {
                $this->gates()->updateExistingPivot($gate_id, ['has_access' => 0]);
            }
        }
    }

    public function isGatesEmpty($gates)
    {
        return empty($gates);
    }

    public function createGates($gates)
    {
        if ($this->isGatesEmpty($gates)) {
            foreach ($gates as $gate_id) {
                $this->gates()->attach($gate_id, ['has_access' => 1], true);
            }
        }
    }

    public function hasAccessToGate(int $gateId)
    {
        foreach ($this->gates as $gate) {
            if ($gate->id == $gateId && $gate->pivot->has_access == 1) {
                return true;
            }
        }

        return false;
    }
}

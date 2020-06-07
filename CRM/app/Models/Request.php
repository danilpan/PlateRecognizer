<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Request
 *
 *
 * @package App\Models
 * @mixin Builder
 */
class Request extends Model
{
    /**
     * @return int
     */
    public function getGateId(): int
    {
        return $this->attributes['gate_id'];
    }

    /**
     * @param int $gate_id
     */
    public function setGateId(int $gate_id): void
    {
        $this->attributes['gate_id'] = $gate_id;
    }

    /**
     * @return string
     */
    public function getRequestImageUrl(): string
    {
        return $this->attributes['request_image_url'];
    }

    /**
     * @param UploadedFile $image
     */
    public function setRequestImageUrl(UploadedFile $image): void
    {
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('gate/'.$this->getGateId().'/enters'), $imageName);

        $this->attributes['request_image_url'] = 'gate/'.$this->getGateId().'/enters/'.$imageName;
    }

    /**
     * @return string
     */
    public function getResponseFromNrp(): string
    {
        return $this->attributes['response_from_nrp'];

    }

    /**
     * @param string $response_from_nrp
     */
    public function setResponseFromNrp(string $response_from_nrp): void
    {
        $this->attributes['response_from_nrp'] = $response_from_nrp;
    }
}

<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreeDPrinterJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => '3dprinterjobs',
            'id' => (string)$this->{$this->getRouteKeyName()},

            'attributes' => [
                'name' => $this->name,
                'job_id' => $this->job_id,
                'status' => $this->status,
                'duration' => $this->duration,
                'started_at' => $this->started_at,
                'machine' => $this->machine,
                'details' => $this->details,
            ],
            'links' => [
                'self' => route('api.threedprinterjobs.show', ['threedprinterjobs' => $this->{$this->getRouteKeyName()}]),
            ],
        ];
    }
}

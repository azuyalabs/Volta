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

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MachineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'machines',
            'id' => (string)$this->id,

            'attributes' => [
                'name' => $this->name,
                'model' => $this->model['manufacturer']['name'] . ' ' . $this->model['name'],
                'acquisition_cost' => (int)$this->acquisition_cost->getAmount(),
                'residual_value' => (int)$this->residual_value->getAmount(),
                'maintenance_cost' => (int)$this->maintenance_cost->getAmount(),
                'lifespan' => $this->lifespan,
                'operating_hours' => $this->operating_hours,
                'energy_consumption' => $this->energy_consumption,
                'type' => $this->type,
                'hourlyRate' => (int)$this->hourlyrate->getAmount(),
                'lifetime_cost' => (int)$this->lifetimecost->getAmount(),
                'reference_id' => $this->reference_id,
                'status' => $this->when($this->reference_id !== null, $this->status),
            ],
            'links' => [
                'self' => route('machines.show', ['machine' => $this->id]),
            ],
        ];
    }
}

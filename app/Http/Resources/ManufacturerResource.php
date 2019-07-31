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
use App\Repositories\CountryRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturerResource extends JsonResource
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
            'type' => 'manufacturers',

            'attributes' => [
                'id' => (string)$this->slug,
                'name' => $this->name,
                'country' => $this->country,
                'website' => $this->website,
                'filament_supplier' => $this->filament_supplier,
                'equipment_supplier' => $this->equipment_supplier,
                'product_count' => $this->models->count()
            ],
            'links' => [
                'self' => \getenv('APP_URL') . '/api/manufacturers/' . $this->slug,
            ],
            'meta' => [
                'country.name' => app(CountryRepository::class)->getName($this->country),
            ],
        ];
    }
}

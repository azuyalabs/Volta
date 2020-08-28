<?php

declare(strict_types=1);
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

class FilamentSpoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'type' => 'filamentspools',
            'id'   => (string) $this->{$this->getRouteKeyName()},

            'attributes' => [
                'name'           => $this->name,
                'manufacturer'   => $this->manufacturer->name,
                'material'       => $this->material,
                'weight'         => $this->weight,
                'diameter'       => $this->diameter,
                'density'        => $this->density,
                'color'          => $this->color,
                'color_value'    => $this->color_value,
                'purchase_price' => $this->purchase_price,
                'unit_price'     => [
                    'length'   => $this->priceperlength,
                    'weight'   => $this->priceperweight,
                    'volume'   => $this->pricepervolume,
                    'kilogram' => $this->priceperkilogram,
                ],
                'length' => [
                    'capacity' => $this->length,
                    'usage'    => $this->usage,
                ],
            ],
            'links' => [
                'self' => route('filamentspools.show', ['filamentspool' => $this->{$this->getRouteKeyName()}]),
            ],
        ];
    }
}

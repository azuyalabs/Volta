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

class ProductResource extends JsonResource
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
            'type' => 'products',

            'attributes' => [
                'id' => (string)$this->slug,
                'name' => $this->name,
                'manufacturer' => ManufacturerResource::make($this->manufacturer),
            ],
            'links' => [
                'self' => route('products.show', ['product' => $this->slug]),
            ]
        ];
    }
}

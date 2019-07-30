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

use Illuminate\Http\Resources\Json\ResourceCollection;

class FilamentSpoolCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => FilamentSpoolResource::collection($this->collection),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        return [
            'links' => [
                'self' => route('filamentspools.index'),
            ],
            'meta' => [
                'currency' => 'JPY',
                'count' => $this->collection->count(),
                'purchase_value' => $this->collection->sum(static function ($spool) {
                    return $spool->purchase_price;
                })
            ],
        ];
    }
}

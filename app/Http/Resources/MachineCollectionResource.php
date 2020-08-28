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
use Illuminate\Http\Resources\Json\ResourceCollection;

class MachineCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'data' => MachineResource::collection($this->collection),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     */
    public function with($request): array
    {
        return [
            'links' => [
                'self' => route('machines.index'),
            ],
            'meta' => [
                'currency'            => auth()->user()->profile->currency ?? 'USD',
                'total_lifetime_cost' => $this->collection->sum(static function ($machine) {
                    return $machine->acquisition_cost->getAmount();
                }),
            ],
        ];
    }
}

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

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Resources\FilamentSpoolResource;

/**
 * Class containing cases for testing the Filament Spool Resource class.
 *
 * @package Tests\Unit\Resources
 */
class FilamentSpoolResourceTest extends TestCase
{
    /** @test */
    public function it_can_return_a_correct_response()
    {
        $resource = (new FilamentSpoolResource($spool = factory('App\FilamentSpool')->create()))->jsonSerialize();

        $this->assertArraySubset(['type' => 'filamentspools', 'id' => $spool->uuid_text], $resource);

        $this->assertArraySubset([
            'attributes' => [
                'name' => $spool->name,
                'manufacturer' => $spool->manufacturer->name,
                'material' => $spool->material,
                'weight' => $spool->weight,
                'diameter' => $spool->diameter,
                'density' => $spool->density,
                'color' => $spool->color,
                'color_value' => $spool->color_value,
                'purchase_price' => $spool->purchase_price,
                'unit_price' => [
                    'length' => $spool->priceperlength,
                    'weight' => $spool->priceperweight,
                    'volume' => $spool->pricepervolume,
                    'kilogram' => $spool->priceperkilogram
                ],
                'length' => [
                    'capacity' => $spool->length,
                    'usage' => $spool->usage,
                ]
            ]
        ], $resource);

        $this->assertArraySubset(['links' => ['self' => \getenv('APP_URL') . '/api/filamentspools/' . $spool->uuid_text]], $resource);
    }
}

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
use App\Repositories\CountryRepository;
use App\Http\Resources\ManufacturerResource;
use App\Manufacturer;

class ManufacturerResourceTest extends TestCase
{
    public function testCorrectDataIsReturnedInResponse(): void
    {
        $resource = (new ManufacturerResource($manufacturer = factory(Manufacturer::class)->create()))->jsonSerialize();

        $this->assertArraySubset(['type' => 'manufacturers'], $resource);

        $this->assertArraySubset([
            'attributes' => [
                'id'                 => $manufacturer->slug,
                'name'               => $manufacturer->name,
                'country'            => $manufacturer->country,
                'website'            => $manufacturer->website,
                'filament_supplier'  => $manufacturer->filament_supplier,
                'equipment_supplier' => $manufacturer->equipment_supplier,
            ]
        ], $resource);

        $this->assertArraySubset(['links' => ['self' => getenv('APP_URL') . '/api/manufacturers/' . $manufacturer->slug]], $resource);

        $this->assertArraySubset(['meta' => ['country.name' => app(CountryRepository::class)->getName($manufacturer->country)]], $resource);
    }
}

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

use App\Http\Resources\ManufacturerResource;
use App\Manufacturer;
use App\Repositories\CountryRepository;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Tests\TestCase;

class ManufacturerResourceTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testCorrectDataIsReturnedInResponse(): void
    {
        $resource = (new ManufacturerResource($manufacturer = factory(Manufacturer::class)->create()))->jsonSerialize();

        self::assertArraySubset(['type' => 'manufacturers'], $resource);

        self::assertArraySubset([
            'attributes' => [
                'id'                 => $manufacturer->slug,
                'name'               => $manufacturer->name,
                'country'            => $manufacturer->country,
                'website'            => $manufacturer->website,
                'filament_supplier'  => $manufacturer->filament_supplier,
                'equipment_supplier' => $manufacturer->equipment_supplier,
            ]
        ], $resource);

        self::assertArraySubset(['links' => ['self' => getenv('APP_URL') . '/api/manufacturers/' . $manufacturer->slug]], $resource);

        self::assertArraySubset(['meta' => ['country.name' => app(CountryRepository::class)->getName($manufacturer->country)]], $resource);
    }
}

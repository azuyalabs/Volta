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

namespace Tests\Unit;

use App\Http\Resources\ManufacturerResource;
use App\Http\Resources\ProductResource;
use App\Manufacturer;
use App\Product;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ProductResourceTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testCorrectDataIsReturnedInResponse(): void
    {
        $resource = (new ProductResource($product = factory(Product::class)->create(['manufacturer_id' => factory(Manufacturer::class)->create()])))->jsonSerialize();

        self::assertArraySubset(['type' => 'products'], $resource);

        self::assertArraySubset([
            'attributes' => [
                'id'   => $product->slug,
                'name' => $product->name,
            ],
        ], $resource);

        $this->assertInstanceOf(ManufacturerResource::class, $resource['attributes']['manufacturer']);

        self::assertArraySubset(['links' => ['self' => getenv('APP_URL').'/api/products/'.$product->slug]], $resource);
    }
}

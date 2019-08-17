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
use App\Http\Resources\ProductResource;
use App\Http\Resources\ManufacturerResource;
use App\Manufacturer;
use App\Product;

class ProductResourceTest extends TestCase
{
    public function testCorrectDataIsReturnedInResponse(): void
    {
        $resource = (new ProductResource($product = factory(Product::class)->create(['manufacturer_id' => factory(Manufacturer::class)->create()])))->jsonSerialize();

        $this->assertArraySubset(['type' => 'products'], $resource);

        $this->assertArraySubset([
            'attributes' => [
                'id'   => $product->slug,
                'name' => $product->name,
            ]
        ], $resource);

        $this->assertInstanceOf(ManufacturerResource::class, $resource['attributes']['manufacturer']);

        $this->assertArraySubset(['links' => ['self' => getenv('APP_URL') . '/api/products/' . $product->slug]], $resource);
    }
}

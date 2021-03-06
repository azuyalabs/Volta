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

use App\FilamentSpool;
use App\Http\Resources\FilamentSpoolResource;
use App\User;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Tests\TestCase;

/**
 * Class containing cases for testing the Filament Spool Resource class.
 *
 * @internal
 * @coversNothing
 */
class FilamentSpoolResourceTest extends TestCase
{
    use ArraySubsetAsserts;

    /** @test
     *
     * @throws \Exception
     */
    public function itCanReturnACorrectResponse(): void
    {
        $user     = factory(User::class)->create();
        $resource = (new FilamentSpoolResource($spool = factory(FilamentSpool::class)->create(['user_id' => $user->id])))->jsonSerialize();

        self::assertArraySubset(['type' => 'filamentspools', 'id' => $spool->id], $resource);

        self::assertArraySubset([
            'attributes' => [
                'name'           => $spool->name,
                'manufacturer'   => $spool->manufacturer->name,
                'material'       => $spool->material,
                'weight'         => $spool->weight,
                'diameter'       => $spool->diameter,
                'density'        => $spool->density,
                'color'          => $spool->color,
                'color_value'    => $spool->color_value,
                'purchase_price' => $spool->purchase_price,
                'unit_price'     => [
                    'length'   => $spool->priceperlength,
                    'weight'   => $spool->priceperweight,
                    'volume'   => $spool->pricepervolume,
                    'kilogram' => $spool->priceperkilogram,
                ],
                'length' => [
                    'capacity' => $spool->length,
                    'usage'    => $spool->usage,
                ],
            ],
        ], $resource);

        self::assertArraySubset(['links' => ['self' => getenv('APP_URL').'/api/filamentspools/'.$spool->id]], $resource);
    }
}

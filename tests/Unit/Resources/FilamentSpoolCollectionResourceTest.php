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
use App\Http\Resources\FilamentSpoolCollectionResource;
use Tests\TestCase;

/**
 * Class containing cases for testing the Filament Spool Resource Collection class.
 *
 * //TODO: Incomplete tests!
 *
 * @internal
 * @coversNothing
 */
class FilamentSpoolCollectionResourceTest extends TestCase
{
    /** @test */
    public function itCanReturnACorrectResponse(): void
    {
        $resource = (new FilamentSpoolCollectionResource($spools = factory(FilamentSpool::class, 2)->create()))->jsonSerialize();

        $this->assertArrayHasKey('data', $resource);
    }
}

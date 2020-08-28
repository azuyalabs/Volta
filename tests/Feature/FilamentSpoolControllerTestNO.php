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

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class FilamentSpoolControllerTestNO extends TestCase
{
    /**
     * TBD.
     */
    public function nottestIndexSuccess(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('spools');

        $response->assertOk();
        $response->assertSee('Filament Spools');
        $response->assertViewIs('spools.index');
    }
}

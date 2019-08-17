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

use App\User;
use Tests\TestCase;

/**
 * Class containing cases for testing the User class.
 *
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    /** @test */
    public function it_can_generate_an_api_token(): void
    {
        $user = factory(User::class)->create(['api_token' => null]);

        $this->assertNull($user->api_token); // Clear the token first

        $user->generateAPIToken();

        $this->assertIsString($user->api_token);
        $this->assertEquals(32, \strlen($user->api_token));
    }
}

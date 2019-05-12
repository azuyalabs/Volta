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
use App\UserProfile;

/**
 * Class containing cases for testing the User class.
 *
 * @package Tests\Unit
 */
class UserProfileTest extends TestCase
{
    /** @test */
    public function it_can_get_preferences_of_a_user()
    {
        $user = User::find(1);

        $this->assertInstanceOf(UserProfile::class, $user->profile);
        $this->assertArrayHasKey('dashboard', $user->profile->preferences);
    }

    /** @test */
    public function it_has_user_relationship()
    {
        $profile = UserProfile::where('user_id', 1)->first();

        $this->assertInstanceOf(User::class, $profile->user);
    }
}
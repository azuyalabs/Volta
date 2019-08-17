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

namespace Tests\Feature;

use App\Machine;
use App\User;
use App\UserProfile;
use Tests\TestCase;

/**
 * Class containing cases for testing the Machine Controller.
 *
 * @package Tests\Feature
 */
class MachineControllerTest extends TestCase
{

    /** @test */
    public function it_can_display_a_list_of_machines(): void
    {
        $user = factory(User::class)->create();
        $machines = factory(Machine::class, 10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/machines');

        // TODO: use assertViewHasAll to check data (can not find example)
        $response->assertOk();
        $response->assertViewIs('machines.index');
    }

    /** @test */
    public function it_can_display_the_edit_screen(): void
    {
        $user = factory(User::class)->create();
        $user->profile()->save(factory(UserProfile::class)->make());
        $machine = factory(Machine::class)->create();

        $response = $this->actingAs($user)->get('/machines/' . $machine->id . '/edit');

        $response->assertOk();
        $response->assertSee($machine->name);
        $response->assertSee($machine->lifespan);
        $response->assertViewIs('machines.edit');
    }
}

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

namespace Tests\Feature\PrinterController;

use App\User;

/**
 * Class containing cases for testing the Verify API Endpoint of the PrinterController.
 *
 * @package Tests\Feature\PrinterController
 */
class VerifyEndpointTest extends PrinterMonitorController
{
    /**
     * The verification API endpoint name
     */
    private const API_ENDPOINT = '/api/printer/verify';

    /** @test */
    public function it_can_correctly_verify_the_client()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->get(self::API_ENDPOINT);

        $response->assertOk();
        $response->assertJson(['name' => $user->name, 'email' => $user->email, 'api_token' => $user->api_token]);
    }

    /** @test */
    public function it_returns_400_status_when_user_agent_header_is_not_present()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => self::ACCEPT_HEADER,
            'User-Agent' => null
        ])->actingAs($user, self::GUARD)->get(self::API_ENDPOINT);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Correct User-Agent header is missing']);
    }

    /** @test */
    public function it_rejects_access_when_user_agent_header_is_incorrect()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => self::ACCEPT_HEADER,
            'User-Agent' => 'LuckyLuke/1.0'
        ])->actingAs($user, self::GUARD)->get(self::API_ENDPOINT);

        $this->assertUnauthenticated($response);
    }

    /** @test */
    public function it_rejects_access_when_no_credentials_are_provided()
    {
        $response = $this->withHeaders([
            'Accept' => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->get(self::API_ENDPOINT);

        $this->assertUnauthenticated($response);
    }

    /** @test */
    public function it_returns_406_status_when_accept_header_is_not_supported()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/xml',
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->get(self::API_ENDPOINT);

        $response->assertStatus(406);
    }
}

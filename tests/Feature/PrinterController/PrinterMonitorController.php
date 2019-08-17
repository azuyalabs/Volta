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

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

/**
 * Base Class containing for testing the Printer Monitor API endpoints.
 *
 * @package Tests\Feature\PrinterController
 */
class PrinterMonitorController extends TestCase
{
    /**
     * The middleware guard used when authenticating clients
     */
    public const GUARD = 'apitoken';

    /**
     * The required User-Agent name
     */
    public const USER_AGENT = 'OctoPrint-Volta/0.1.1';

    /**
     * The required (supported) Accept type
     */
    public const ACCEPT_HEADER = 'application/json';

    /**
     * Assert that the response is 401: Unauthenticated
     *
     * @param TestResponse $response
     */
    public function assertUnauthenticated(TestResponse $response): void
    {
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}

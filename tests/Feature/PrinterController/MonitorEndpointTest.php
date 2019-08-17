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
 * Class containing cases for testing the Monitor API Endpoint of the PrinterController.
 *
 * @package Tests\Feature\PrinterController
 */
class MonitorEndpointTest extends PrinterMonitorController
{
    private const API_ENDPOINT = '/api/printer/monitor';

    /** @test */
    public function it_returns_405_status_when_unsupported_method_is_used(): void
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept'     => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->get(self::API_ENDPOINT);

        $response->assertStatus(405);
    }

    /** @test */
    public function it_can_submit_monitor_data_correctly(): void
    {
        $user    = factory(User::class)->create();
        $printer = 'ender3@192.168.1.10:5000';

        $response = $this->withHeaders([
            'Accept'     => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->post(
            self::API_ENDPOINT,
            [
                'id'    => $this->encryptPrinterID($printer, $user->api_token),
                'name'  => 'Ender 3',
                'state' => 'offline'
            ]
        );

        $response->assertStatus(201);
        $response->assertJson([
            'status'  => 'ok',
            'message' => sprintf('Data for printer `%s` successfully received.', $printer)
        ]);
    }

    /**
     * Helper function to create a valid encrypted printer ID sample
     *
     * @param $data string the printer address (i.e. ID)
     * @param $key string the encryption key (the users' API token)
     * @return string string the encrypted printer address
     */
    private function encryptPrinterID($data, $key): string
    {
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cfb8'));

        // Encrypt the data using AES 256 encryption in CFB8 mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cfb8', $key, 1, $iv);

        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    /** @test */
    public function it_returns_422_status_when_using_invalid_printer_id(): void
    {
        $user    = factory(User::class)->create();
        $printer = 'mk25@192.168.1.10:5000';

        $response = $this->withHeaders([
            'Accept'     => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->post(
            self::API_ENDPOINT,
            [
                'id'    => $this->encryptPrinterID($printer, $this->faker->word),
                'name'  => 'Prusa MK2.5',
                'state' => 'printing'
            ]
        );

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'id' => ['The printer id is not valid. It must be a properly formatted and encoded string.'],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }

    /** @test */
    public function it_returns_422_status_when_no_data_is_submitted(): void
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept'     => self::ACCEPT_HEADER,
            'User-Agent' => self::USER_AGENT
        ])->actingAs($user, self::GUARD)->post(self::API_ENDPOINT);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'id'    => ['The id field is required.'],
                'name'  => ['The name field is required.'],
                'state' => ['The state field is required.']
            ],
            'message' => 'The given data was invalid.'
        ]);
    }
}

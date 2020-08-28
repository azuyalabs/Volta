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

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Rule class defining the rules for the printer ID.
 */
class ValidPrinterId implements Rule
{
    /**
     * @var string the decoded printer ID
     */
    public $printerId;

    /**
     * @var string the API token of the user needed for decoding the printer ID
     */
    private $apiToken;

    /**
     * Create a new rule instance.
     *
     * @param string $apiToken the API Token of the user
     */
    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        // To decrypt, split the encrypted data from IV - unique separator used was "::"
        $_dValue = base64_decode(str_replace(['-', '_'], ['+', '/'], $value));
        if (!$_dValue) {
            return false;
        }

        $encodedPrinterId = explode('::', $_dValue);

        // Check if the Base64 decoded value is a valid 2 element array
        if (!is_array($encodedPrinterId) || 1 === count($encodedPrinterId)) {
            return false;
        }

        // Try to decrypt the encoded printer ID with the given API Token
        // Check if the decoded printer ID matches the string pattern ('<machine>@<host>:<port>')
        $printerIdDecoded = openssl_decrypt($encodedPrinterId[0], 'aes-256-cfb8', $this->apiToken, 1, $encodedPrinterId[1]);
        if (!$printerIdDecoded) {
            return false;
        }

        if (1 !== preg_match('/^\S+@\S+:\d{1,5}$/', $printerIdDecoded)) {
            return false;
        }

        $this->printerId = $printerIdDecoded;

        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The printer :attribute is not valid. It must be a properly formatted and encoded string.';
    }
}

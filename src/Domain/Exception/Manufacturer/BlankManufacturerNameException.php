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

declare(strict_types=1);

namespace Volta\Domain\Exception\Manufacturer;

use Volta\Domain\Exception\Exception;

class BlankManufacturerNameException extends \InvalidArgumentException implements Exception
{
    public function __construct(
        string $message = 'manufacturer name can not be blank',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
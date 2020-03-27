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

namespace Volta\Domain\Exception\FilamentSpool;

use Volta\Domain\Exception\Exception;

class MaximumValueMaximumFanSpeedException extends \UnexpectedValueException implements Exception
{
    public function __construct(
        string $message = 'maximum fan speed can not exceed 100',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

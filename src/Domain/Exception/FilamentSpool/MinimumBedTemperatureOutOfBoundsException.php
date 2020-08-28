<?php

declare(strict_types=1);

namespace Volta\Domain\Exception\FilamentSpool;

use Volta\Domain\Exception\Exception;

class MinimumBedTemperatureOutOfBoundsException extends \RangeException implements Exception
{
    public function __construct(
        string $message = 'minimum bed temperature is out of range',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

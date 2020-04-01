<?php

namespace Volta\Domain\Exception\FilamentSpool;

use Volta\Domain\Exception\Exception;

class MinimumPrintTemperatureOutOfBoundsException extends \RangeException implements Exception
{
    public function __construct(
        string $message = 'minimum print temperature is out of range',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

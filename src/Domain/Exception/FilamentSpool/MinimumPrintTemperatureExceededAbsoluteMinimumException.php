<?php

namespace Volta\Domain\Exception\FilamentSpool;

use Volta\Domain\Exception\Exception;

class MinimumPrintTemperatureExceededAbsoluteMinimumException extends \RangeException implements Exception
{
    public function __construct(
        string $message = 'minimum print temperature can not exceed absolute minimum',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

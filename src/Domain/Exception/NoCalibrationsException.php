<?php

declare(strict_types=1);

namespace Volta\Domain\Exception;

class NoCalibrationsException extends \UnexpectedValueException implements Exception
{
    public function __construct(
        string $message = 'there are no calibrations with this name',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

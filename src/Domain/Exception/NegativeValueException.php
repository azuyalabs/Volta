<?php

namespace Volta\Domain\Exception;

class NegativeValueException extends \UnexpectedValueException implements Exception
{
    public function __construct(
        string $attribute = 'attribute',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct(sprintf('%s can not be negative', $attribute), $code, $previous);
    }
}

<?php

declare(strict_types=1);

namespace Volta\Domain\Exception;

class ZeroValueException extends \UnexpectedValueException implements Exception
{
    public function __construct(
        string $attribute = 'attribute',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct(sprintf('%s can not be zero', $attribute), $code, $previous);
    }
}

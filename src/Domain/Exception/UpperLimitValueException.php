<?php
declare(strict_types=1);

namespace Volta\Domain\Exception;

class UpperLimitValueException extends \UnexpectedValueException implements Exception
{
    public function __construct(
        string $attribute = 'attribute',
        float $limit = 1,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct(sprintf('%s can not exceed %s', $attribute, $limit), $code, $previous);
    }
}

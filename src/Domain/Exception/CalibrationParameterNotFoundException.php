<?php

declare(strict_types=1);

namespace Volta\Domain\Exception;

use Psr\Container\NotFoundExceptionInterface;

class CalibrationParameterNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
    public function __construct(string $key, \Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);
        $this->message = $key;
    }
}

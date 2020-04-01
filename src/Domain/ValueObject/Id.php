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

namespace Volta\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Volta\Domain\Exception\InvalidIdException;

abstract class Id
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $value;

    /**
     * @throws \Exception
     */
    final public function __construct()
    {
        $this->value = Uuid::uuid4();
    }

    /**
     * @param string $id
     *
     * @return Id
     * @throws \Exception
     */
    public static function fromString(string $id): Id
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidIdException(sprintf('Invalid Id for %s', static::class));
        }

        $result        = new static();
        $result->value = Uuid::fromString($id);

        return $result;
    }

    public function isEqual(Id $value): bool
    {
        if (get_class($value) !== static::class) {
            return false;
        }

        return $this->getValue() === $value->getValue();
    }

    public function getValue(): string
    {
        return $this->value->toString();
    }

    /**
     * Doctrine requires to have __toString on identifiers
     *
     * @see getValue
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}

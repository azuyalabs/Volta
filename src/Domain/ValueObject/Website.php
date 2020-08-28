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

use Volta\Domain\Exception\InvalidWebsiteException;

class Website
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Website $website): bool
    {
        if (!$website instanceof static) {
            return false;
        }

        return $website->value === $this->value;
    }

    private function validate(): void
    {
        if (false === \filter_var($this->value, \FILTER_VALIDATE_URL)) {
            throw new InvalidWebsiteException('inval');
        }
    }
}

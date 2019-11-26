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

namespace Volta\Domain;

use Money\Money;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    /**
     * @var FilamentSpoolId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $purchasePrice;

    public function __construct(
        FilamentSpoolId $id,
        string $name,
        Money $purchasePrice
    ) {
        $this->id            = $id;
        $this->name          = $name;
        $this->purchasePrice = $purchasePrice;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return FilamentSpoolId
     */
    public function getId(): FilamentSpoolId
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return FilamentSpool
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Money $purchasePrice
     * @return FilamentSpool
     */
    public function setPurchasePrice(Money $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;
        return $this;
    }

    /**
     * @return Money
     */
    public function getPurchasePrice(): Money
    {
        return $this->purchasePrice;
    }
}

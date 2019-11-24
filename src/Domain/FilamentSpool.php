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

    public function __construct(
        FilamentSpoolId $id,
        string $name
    ) {
        $this->id   = $id;
        $this->name = $name;
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
}

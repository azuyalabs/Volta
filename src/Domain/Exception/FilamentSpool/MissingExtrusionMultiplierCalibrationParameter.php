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

namespace Volta\Domain\Exception\FilamentSpool;

use Volta\Domain\Exception\Exception;

class MissingExtrusionMultiplierCalibrationParameter extends \DomainException implements Exception
{
    public function __construct(
        string $parameter,
        \Throwable $previous = null
    ) {
        parent::__construct(
            sprintf('extrusion multiplier calibration has no "%s" parameter', $parameter),
            0,
            $previous
        );
    }
}

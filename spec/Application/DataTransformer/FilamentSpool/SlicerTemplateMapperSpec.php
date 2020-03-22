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

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use Tests\FilamentSpoolBuilder;
use Volta\Application\DataTransformer\FilamentSpool\SlicerTemplate;
use Volta\Domain\Manufacturer;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class SlicerTemplateMapperSpec extends ObjectBehavior
{
    public function it_maps_from_domain(SlicerTemplate $dto): void
    {
        $builder = new FilamentSpoolBuilder();
        $builder->withManufacturer(new Manufacturer(new ManufacturerId(), new ManufacturerName('ABC Plastics')));
        $builder->withDiameter(new Length(2.1, 'millimeter'));
        $spool = $builder->build();

        $this->mapFromDomain($spool, $dto);

        //$dto->setDiameter(2.1)->shouldHaveBeenCalled();
        $dto->setManufacturer('ABC Plastics')->shouldHaveBeenCalled();
    }
}

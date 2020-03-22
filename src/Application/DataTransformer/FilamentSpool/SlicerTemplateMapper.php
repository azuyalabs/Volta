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

namespace Volta\Application\DataTransformer\FilamentSpool;

use Volta\Domain\FilamentSpool;

class SlicerTemplateMapper
{
    public function mapFromDomain(FilamentSpool $spool, SlicerTemplate $dto): void
    {
        $dto->setDiameter($spool->getDiameter()->toNativeUnit());
        /*
        $dto->setName($reviewer->getName()->getValue());
        $dto->setGender($reviewer->getGender()->getValue());
        $dto->setNationality($reviewer->getNationality()->getValue());
        $dto->setBirthYear($reviewer->getBirthYear()->getValue());
        $dto->setSpecializationOneFirst($reviewer->getSpecializationOne()->getFirstLevel());
        $dto->setSpecializationOneSecond($reviewer->getSpecializationOne()->getSecondLevel());
        $dto->setSpecializationOneThird($reviewer->getSpecializationOne()->getThirdLevel());
        $dto->setSpecializationTwoFirst($reviewer->getSpecializationTwo()->getFirstLevel());
        $dto->setSpecializationTwoSecond($reviewer->getSpecializationTwo()->getSecondLevel());
        $dto->setSpecializationTwoThird($reviewer->getSpecializationTwo()->getThirdLevel());
        $dto->setSpecializationThreeFirst($reviewer->getSpecializationThree()->getFirstLevel());
        $dto->setSpecializationThreeSecond($reviewer->getSpecializationThree()->getSecondLevel());
        $dto->setSpecializationThreeThird($reviewer->getSpecializationThree()->getThirdLevel());
        $dto->setOtherSpecializationOne($reviewer->getOtherSpecialization()->getFirst());
        $dto->setOtherSpecializationTwo($reviewer->getOtherSpecialization()->getSecond());
        $dto->setOtherSpecializationThree($reviewer->getOtherSpecialization()->getThird());
        $dto->setInstitution($reviewer->getInstitution()->getValue());
        $dto->setPosition($reviewer->getPosition()->getValue());
        $dto->setDepartment($reviewer->getDepartment()->getValue());
        $dto->setLineOne($reviewer->getAddress()->getLineOne());
        $dto->setLineTwo($reviewer->getAddress()->getLineTwo());
        $dto->setState($reviewer->getAddress()->getState());
        $dto->setCountry($reviewer->getAddress()->getCountry());
        $dto->setPostalCode($reviewer->getAddress()->getZipCode());
        $dto->setPhoneNumber($reviewer->getPhoneNumber()->getValue());
        $dto->setHonorarium($reviewer->isAcceptingHonorarium());
        $dto->setAdministrationEmail($reviewer->getAdministrationEmail()->getValue());
        $dto->setAbroadAnniversary($reviewer->getAbroadAnniversary());
        $dto->setDegree($reviewer->getDegree()->getValue());
        $dto->setReviewFinderId($reviewer->getReviewFinderId()->getValue());
        $dto->setRecommendedBy($reviewer->getRecommendedBy()->getValue());
        */
    }
}

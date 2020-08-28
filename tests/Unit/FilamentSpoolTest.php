<?php

declare(strict_types=1);
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

namespace Tests\Unit;

use App\FilamentSpool;
use App\User;
use Cknow\Money\Money;
use Faker\Factory as Faker;
use Tests\TestCase;
use UnexpectedValueException;

/**
 * Class containing cases for testing the Filament Spool class.
 *
 * @internal
 * @coversNothing
 */
class FilamentSpoolTest extends TestCase
{
    /**
     * Number of iterations generating test samples.
     */
    private const ITERATIONS = 5;

    /**
     * @var User user instance to use for creating Spool instances
     */
    private $_user;

    /** {@inheritdoc} */
    public function setUp(): void
    {
        parent::setUp();
        $this->_user = factory(User::class)->create();
    }

    /** {@inheritdoc}
     *
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->_user = null;
    }

    /**
     * @test
     *
     * @dataProvider PricePerKilogramDataProvider
     *
     * @param $price int test sample for purchase price
     * @param $weight int test sample for weight
     * @param $expected float the expected price per kilogram
     */
    public function itCalculatesCorrectPricePerKilogram($price, $weight, $expected): void
    {
        $spool = $this->createSpoolInstance(['purchase_price' => $price, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperkilogram);
        $this->assertEquals($expected, $spool->priceperkilogram->getAmount());
    }

    /** @test */
    public function itCalculatesPricePerKilogramAsZeroWhenPriceZero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => 0]);

        $this->assertInstanceOf(Money::class, $spool->priceperkilogram);
        $this->assertEquals(0, $spool->priceperkilogram->getAmount());
    }

    /** @test */
    public function itThrowsAnExceptionForPricePerKilogramWhenWeightIsZero(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'weight' => 0]);

        $this->assertEquals(0, $spool->priceperkilogram);
    }

    /**
     * @test
     *
     * @dataProvider LengthDataProvider
     *
     * @param $weight int test sample for weight
     * @param $density float test sample for density
     * @param $diameter float test sample for diameter
     * @param $expected float the expected length
     */
    public function itCalculatesCorrectSpoolLength($weight, $density, $diameter, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'density' => $density, 'diameter' => $diameter, 'weight' => $weight]);

        $this->assertIsFloat($spool->length);
        $this->assertGreaterThan(0, $spool->length);
        $this->assertEquals($expected, $spool->length);
    }

    /** @test */
    public function itThrowsAnExceptionForLengthWhenDensityIsZero(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'density' => 0]);

        $this->assertEquals(0, $spool->length);
    }

    /** @test */
    public function itThrowsAnExceptionForLengthWhenDiameterIsZero(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'diameter' => 0]);

        $this->assertEquals(0, $spool->length);
    }

    /** @test */
    public function itCalculatesSpoolLengthIsZeroWhenWeightIsZero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'weight' => 0]);

        $this->assertIsFloat($spool->length);
        $this->assertEquals(0, $spool->length);
    }

    /**
     * @test
     *
     * @dataProvider PricePerLengthDataProvider
     *
     * @param $price int test sample for purchase price
     * @param $weight int test sample for weight
     * @param $density float test sample for density
     * @param $diameter float test sample for diameter
     * @param $expected float the expected price per length
     */
    public function itCalculatesCorrectPricePerLength($price, $weight, $density, $diameter, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => $price, 'density' => $density, 'diameter' => $diameter, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperlength);
        $this->assertEquals($expected, $spool->priceperlength->getAmount());
    }

    /** @test */
    public function itCalculatesPricePerLengthAsZeroWhenPriceZero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => 0]);

        $this->assertInstanceOf(Money::class, $spool->priceperlength);
        $this->assertEquals(0, $spool->priceperlength->getAmount());
    }

    /**
     * @test
     *
     * @dataProvider PricePerWeightDataProvider
     *
     * @param $price int test sample for purchase price
     * @param $weight int test sample for weight
     * @param $expected float the expected price per length
     */
    public function itCalculatesCorrectPricePerWeight($price, $weight, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => $price, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperweight);
        $this->assertEquals($expected, $spool->priceperweight->getAmount());
    }

    /** @test */
    public function itCalculatesPricePerWeightAsZeroWhenPriceZero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => 0]);

        $this->assertInstanceOf(Money::class, $spool->priceperweight);
        $this->assertEquals(0, $spool->priceperweight->getAmount());
    }

    /**
     * @test
     *
     * @dataProvider PricePerVolumeDataProvider
     *
     * @param $price int test sample for purchase price
     * @param $weight int test sample for weight
     * @param $density float test sample for density
     * @param $expected float the expected price per length
     */
    public function itCalculatesCorrectPricePerVolume($price, $weight, $density, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id, 'purchase_price' => $price, 'weight' => $weight, 'density' => $density]);

        $this->assertInstanceOf(Money::class, $spool->pricepervolume);
        $this->assertEquals($expected, $spool->pricepervolume->getAmount());
    }

    /** @test */
    public function itCanMarkSpoolAsEmpty(): void
    {
        $spool = factory(FilamentSpool::class)->create(['user_id' => $this->_user->id]);

        $this->assertLessThanOrEqual($spool->length, $spool->usage);
        $this->assertFalse($spool->isEmpty());

        $spool->markAsEmpty();

        $this->assertEquals($spool->length, $spool->usage);
        $this->assertTrue($spool->isEmpty());
    }

    public function PricePerWeightDataProvider(): array
    {
        $otherData = $this->PricePerKilogramDataProvider();
        $data      = [];
        foreach ($otherData as $sample) {
            $data[] = [$sample[0], $sample[1], (int) round($sample[0] / $sample[1])];
        }

        return $data;
    }

    public function PricePerKilogramDataProvider(): array
    {
        $data = [];
        for ($y = 1; $y <= self::ITERATIONS; ++$y) {
            $purchase_price = Faker::create()->numberBetween(1, 500000);
            $weight         = Faker::create()->numberBetween(400, 5000);

            $data[] = [$purchase_price, $weight, (int) round((1000 / $weight) * $purchase_price)];
        }

        return $data;
    }

    public function PricePerVolumeDataProvider(): array
    {
        $otherData = $this->PricePerLengthDataProvider();
        $data      = [];
        foreach ($otherData as $sample) {
            $data[] = [$sample[0], $sample[1], $sample[2], (int) round($sample[0] / ($sample[1] / $sample[2]))];
        }

        return $data;
    }

    public function PricePerLengthDataProvider(): array
    {
        $lengthData = $this->LengthDataProvider();
        $data       = [];
        foreach ($lengthData as $sample) {
            $purchase_price = Faker::create()->numberBetween(1, 500000);
            $data[]         = [$purchase_price, $sample[0], $sample[1], $sample[2], (int) round($purchase_price / $sample[3])];
        }

        return $data;
    }

    public function LengthDataProvider(): array
    {
        $data = [];
        for ($y = 1; $y <= self::ITERATIONS; ++$y) {
            $weight   = Faker::create()->numberBetween(1, 5000);
            $density  = Faker::create()->randomFloat(2, 1, 5);
            $diameter = Faker::create()->randomFloat(2, 1, 5);

            $data[] = [$weight, $density, $diameter, ($weight / $density) / (M_PI * (($diameter / 2) ** 2))];
        }

        return $data;
    }

    /**
     * Creates a test FilamentSpool instance with the given attribute values.
     *
     * @param array $modelData model attribute values
     */
    private function createSpoolInstance(array $modelData): FilamentSpool
    {
        $data = ['user_id' => $this->_user->id];
        $data = array_merge($data, $modelData);

        return factory(FilamentSpool::class)->create($data);
    }
}

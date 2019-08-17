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

namespace Tests\Unit;

use App\FilamentSpool;
use Cknow\Money\Money;
use Faker\Factory as Faker;
use Tests\TestCase;

/**
 * Class containing cases for testing the Filament Spool class.
 *
 * @package Tests\Unit
 */
class FilamentSpoolTest extends TestCase
{
    /**
     * Number of iterations generating test samples
     */
    private const ITERATIONS = 2;

    /**
     * @test
     *
     * @dataProvider PricePerKilogramDataProvider
     *
     * @param $price int test sample for purchase price
     * @param $weight int test sample for weight
     * @param $expected float the expected price per kilogram
     */
    public function it_calculates_correct_price_per_kilogram($price, $weight, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => $price, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperkilogram);
        $this->assertEquals($expected, $spool->priceperkilogram->getAmount());
    }

    /** @test */
    public function it_calculates_price_per_kilogram_as_zero_when_price_zero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => 0]);

        $this->assertInstanceOf(Money::class, $spool->priceperkilogram);
        $this->assertEquals(0, $spool->priceperkilogram->getAmount());
    }

    /** @test */
    public function it_throws_an_exception_for_price_per_kilogram_when_weight_is_zero(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['weight' => 0]);

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
    public function it_calculates_correct_spool_length($weight, $density, $diameter, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['density' => $density, 'diameter' => $diameter, 'weight' => $weight]);

        $this->assertIsFloat($spool->length);
        $this->assertGreaterThan(0, $spool->length);
        $this->assertEquals($expected, $spool->length);
    }

    /** @test */
    public function it_throws_an_exception_for_length_when_density_is_zero(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['density' => 0]);

        $this->assertEquals(0, $spool->length);
    }

    /** @test */
    public function it_throws_an_exception_for_length_when_diameter_is_zero(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $spool = factory(FilamentSpool::class)->create(['diameter' => 0]);

        $this->assertEquals(0, $spool->length);
    }

    /** @test */
    public function it_calculates_spool_length_is_zero_when_weight_is_zero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['weight' => 0]);

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
    public function it_calculates_correct_price_per_length($price, $weight, $density, $diameter, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => $price, 'density' => $density, 'diameter' => $diameter, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperlength);
        $this->assertEquals($expected, $spool->priceperlength->getAmount());
    }

    /** @test */
    public function it_calculates_price_per_length_as_zero_when_price_zero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => 0]);

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
    public function it_calculates_correct_price_per_weight($price, $weight, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => $price, 'weight' => $weight]);

        $this->assertInstanceOf(Money::class, $spool->priceperweight);
        $this->assertEquals($expected, $spool->priceperweight->getAmount());
    }

    /** @test */
    public function it_calculates_price_per_weight_as_zero_when_price_zero(): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => 0]);

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
    public function it_calculates_correct_price_per_volume($price, $weight, $density, $expected): void
    {
        $spool = factory(FilamentSpool::class)->create(['purchase_price' => $price, 'weight' => $weight, 'density' => $density]);

        $this->assertInstanceOf(Money::class, $spool->pricepervolume);
        $this->assertEquals($expected, $spool->pricepervolume->getAmount());
    }

    /** @test */
    public function it_can_mark_spool_as_empty(): void
    {
        $spool = factory(FilamentSpool::class)->create();

        $this->assertLessThanOrEqual($spool->length, $spool->usage);
        $this->assertFalse($spool->isEmpty());

        $spool->markAsEmpty();

        $this->assertEquals($spool->length, $spool->usage);
        $this->assertTrue($spool->isEmpty());
    }

    /**
     * @return array
     */
    public function PricePerWeightDataProvider(): array
    {
        $otherData = $this->PricePerKilogramDataProvider();
        $data = [];
        foreach ($otherData as $sample) {
            $data[] = [$sample[0], $sample[1], (int)\round($sample[0] / $sample[1])];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function PricePerKilogramDataProvider(): array
    {
        $data = [];
        for ($y = 1; $y <= self::ITERATIONS; $y++) {
            $purchase_price = Faker::create()->numberBetween(1, 500000);
            $weight = Faker::create()->numberBetween(400, 5000);

            $data[] = [$purchase_price, $weight, (int)\round((1000 / $weight) * $purchase_price)];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function PricePerVolumeDataProvider(): array
    {
        $otherData = $this->PricePerLengthDataProvider();
        $data = [];
        foreach ($otherData as $sample) {
            $data[] = [$sample[0], $sample[1], $sample[2], (int)\round($sample[0] / ($sample[1] / $sample[2]))];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function PricePerLengthDataProvider(): array
    {
        $lengthData = $this->LengthDataProvider();
        $data = [];
        foreach ($lengthData as $sample) {
            $purchase_price = Faker::create()->numberBetween(1, 500000);
            $data[] = [$purchase_price, $sample[0], $sample[1], $sample[2], (int)\round($purchase_price / $sample[3])];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function LengthDataProvider(): array
    {
        $data = [];
        for ($y = 1; $y <= self::ITERATIONS; $y++) {
            $weight = Faker::create()->numberBetween(1, 5000);
            $density = Faker::create()->randomFloat(2, 1, 5);
            $diameter = Faker::create()->randomFloat(2, 1, 5);

            $data[] = [$weight, $density, $diameter, ($weight / $density) / (M_PI * (($diameter / 2) ** 2))];
        }
        return $data;
    }
}

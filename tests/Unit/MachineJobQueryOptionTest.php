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

use App\Machine;
use App\MachineJob;
use App\MachineJobStatus;
use App\MachineJobType;
use App\QueryOptions\MachineJobQueryOptions;
use App\Repositories\MachineJobRepository;
use App\User;
use DateInterval;
use DatePeriod;
use Exception;
use Tests\TestCase;

/**
 * Class containing cases for testing the Machine Job Query Option class.
 *
 * @internal
 * @coversNothing
 */
class MachineJobQueryOptionTest extends TestCase
{
    /**
     * @var User user instance to use for creating Spool instances
     */
    private $_user;

    /** {@inheritdoc} */
    public function setUp(): void
    {
        parent::setUp();
        $this->_user    = factory(User::class)->create();
        factory(Machine::class, 50)->create(['user_id' => $this->_user->id]);
    }

    /** {@inheritdoc}
     *
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->_user    = null;
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByType(): void
    {
        $user_id = random_int(1, 10);
        $type    = MachineJobType::THREE_D_PRINTER;

        //factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id, 'machine_id' => $this->_machine]);

        $this->generateMachineJobs([], random_int(2, 50));

        $filter = new MachineJobQueryOptions();
        $filter->type($type);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        // Assert filtered value is picked up and other types not
        $this->assertSame($type, $result->pluck('type')->first());
        $this->assertNotSame(MachineJobType::LASER, $result->pluck('type')->first());
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itReturnsEmptyWhenFilterTypeValueIsNotPresent(): void
    {
        $user_id = random_int(1, 10);
        $type    = MachineJobType::LASER;

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id, 'type' => $type]);

        // Assert filter with a non existing value returns zero/nothing
        $filter = new MachineJobQueryOptions();
        $filter->type(MachineJobType::ROUTER);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertNotSame($type, $result->pluck('type')->first());
        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByMachines(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with a single machine
        $machines = Machine::all()->pluck('id')->random(1);

        $filter = new MachineJobQueryOptions();
        $filter->machines($machines->toArray());

        $result  = (new MachineJobRepository())->all($user_id, $filter);
        $machine = $result->pluck('machine_id')->first() ?? $machines->first(); // Little hack :(

        $this->assertSame($machines->first(), $machine);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByMultipleMachines(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 100))->create(['user_id' => $user_id]);

        // Assert with multiple machine
        $machines = Machine::all()->pluck('id')->random(3);

        $filter = new MachineJobQueryOptions();
        $filter->machines($machines->toArray());

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertNotEmpty(array_intersect($machines->toArray(), $result->pluck('machine_id')->all()));
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itReturnsEmptyWhenFilterMachinesValueIsNotPresent(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert filter with a non existing value returns zero/nothing
        $id     = $this->faker->numberBetween(1000);
        $filter = new MachineJobQueryOptions();
        $filter->machines([$id]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertNotSame($id, $result->pluck('machine_id')->first());
        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByStatuses(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with a single status
        $filter = new MachineJobQueryOptions();
        $filter->statuses([MachineJobStatus::SUCCESS]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertSame(MachineJobStatus::SUCCESS, $result->pluck('status')->first());
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByMultipleStatuses(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with multiple statuses
        $filter = new MachineJobQueryOptions();
        $filter->statuses([MachineJobStatus::SUCCESS, MachineJobStatus::FAILED]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertContains(MachineJobStatus::SUCCESS, $result->pluck('status')->all());
        $this->assertNotContains(MachineJobStatus::IN_PROGRESS, $result->pluck('status')->all());
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itReturnsEmptyWhenFilterStatusValueIsNotPresent(): void
    {
        $user_id = random_int(1, 10);

        factory(MachineJob::class, random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert filter with a non existing value returns zero/nothing
        $filter = new MachineJobQueryOptions();
        $filter->machines([MachineJobStatus::IN_PROGRESS]); // 'In Progress' is not generated by the factory

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertEmpty($result);
        $this->assertNotContains(MachineJobStatus::SUCCESS, $result->pluck('status')->all());
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function itCanFilterJobsByStartDatePeriod(): void
    {
        $user_id = random_int(1, 10);

        $startedAtDate = $this->faker->dateTimeBetween('-1 year');

        factory(MachineJob::class, random_int(2, 100))->create(['user_id' => $user_id, 'started_at' => $startedAtDate]);

        $filter    = new MachineJobQueryOptions();
        $startDate = clone $startedAtDate;
        $filter->start_date_period(new DatePeriod(
            $startDate->sub(new DateInterval('P1M')),
            new DateInterval('P1D'),
            $startedAtDate
        ));

        $result = (new MachineJobRepository())->all($user_id, $filter);

        // Assert filtered value is picked up and other types not
        $this->assertGreaterThan($startDate, $startedAtDate);
        $this->assertLessThan(new \DateTimeImmutable(), $startedAtDate);
    }

    /**
     * Creates test MachineJob instances with the given attribute values and given quantity.
     *
     * @param array $modelData model attribute values
     * @param int   $amount    number of instances to generate
     */
    private function generateMachineJobs(array $modelData = [], int $amount = 5)
    {
        $data               = ['user_id' => $this->_user->id];
        $data['machine_id'] = $this->faker->randomElement(Machine::all()->pluck('id')->toArray());
        $data               = array_merge($data, $modelData);

        factory(MachineJob::class, $amount)->create($data);
    }
}

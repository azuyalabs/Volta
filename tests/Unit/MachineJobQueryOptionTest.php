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

use App\Machine;
use App\MachineJob;
use Tests\TestCase;
use App\MachineJobType;
use App\MachineJobStatus;
use App\Repositories\MachineJobRepository;
use App\QueryOptions\MachineJobQueryOptions;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class containing cases for testing the Machine Job Query Option class.
 *
 * @package Tests\Unit
 */
class MachineJobQueryOptionTest extends TestCase
{
    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_type()
    {
        $user_id = \random_int(1, 10);
        $type = MachineJobType::THREE_D_PRINTER;

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

        $filter = new MachineJobQueryOptions();
        $filter->type($type);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        // Assert filtered value is picked up and other types not
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($type, $result->pluck('type')->first());
        $this->assertNotSame(MachineJobType::LASER, $result->pluck('type')->first());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_returns_empty_when_filter_type_value_is_not_present()
    {
        $user_id = \random_int(1, 10);
        $type = MachineJobType::LASER;

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id, 'type' => $type]);

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
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_machines()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with a single machine
        $machines = Machine::all()->pluck('id')->random(1);

        $filter = new MachineJobQueryOptions();
        $filter->machines($machines->toArray());

        $result = (new MachineJobRepository())->all($user_id, $filter);
        $machine = $result->pluck('machine_id')->first() ?? $machines->first(); // Little hack :(

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($machines->first(), $machine);
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_multiple_machines()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 100))->create(['user_id' => $user_id]);

        // Assert with multiple machine
        $machines = Machine::all()->pluck('id')->random(3);

        $filter = new MachineJobQueryOptions();
        $filter->machines($machines->toArray());

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertNotEmpty(\array_intersect($machines->toArray(), $result->pluck('machine_id')->all()));
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_returns_empty_when_filter_machines_value_is_not_present()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert filter with a non existing value returns zero/nothing
        $id = $this->faker->numberBetween(1000);
        $filter = new MachineJobQueryOptions();
        $filter->machines([$id]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertNotSame($id, $result->pluck('machine_id')->first());
        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_statuses()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with a single status
        $filter = new MachineJobQueryOptions();
        $filter->statuses([MachineJobStatus::SUCCESS]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame(MachineJobStatus::SUCCESS, $result->pluck('status')->first());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_multiple_statuses()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

        // Assert with multiple statuses
        $filter = new MachineJobQueryOptions();
        $filter->statuses([MachineJobStatus::SUCCESS, MachineJobStatus::FAILED]);

        $result = (new MachineJobRepository())->all($user_id, $filter);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertContains(MachineJobStatus::SUCCESS, $result->pluck('status')->all());
        $this->assertNotContains(MachineJobStatus::IN_PROGRESS, $result->pluck('status')->all());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_returns_empty_when_filter_status_value_is_not_present()
    {
        $user_id = \random_int(1, 10);

        factory(MachineJob::class, \random_int(2, 50))->create(['user_id' => $user_id]);

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
     * @throws \Exception
     */
    public function it_can_filter_jobs_by_start_date_period()
    {
        $user_id = \random_int(1, 10);

        $startedAtDate = $this->faker->dateTimeBetween('-1 year', 'now');

        factory(MachineJob::class, \random_int(2, 100))->create(['user_id' => $user_id, 'started_at' => $startedAtDate]);

        $filter = new MachineJobQueryOptions();
        $startDate = clone $startedAtDate;
        $filter->start_date_period((new \DatePeriod(
            $startDate->sub(new \DateInterval('P1M')),
            new \DateInterval('P1D'),
            $startedAtDate
        )
        ));

        $result = (new MachineJobRepository())->all($user_id, $filter);

        // Assert filtered value is picked up and other types not
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan($startDate, $startedAtDate);
        $this->assertLessThan(new \DateTime(), $startedAtDate);
    }
}
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

use App\Http\Requests\MachineJob as MachineJobRequest;
use App\Machine;
use App\MachineJob;
use App\MachineJobStatus;
use App\MachineJobType;
use App\QueryOptions\MachineJobQueryOptions;
use App\Repositories\MachineJobRepository;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

/**
 * Class containing cases for testing the Machine Job Repository class.
 */
class MachineJobRepositoryTest extends TestCase
{
    /** @test */
    public function it_can_find_machine_jobs_by_uuid(): void
    {
        $job = factory(MachineJob::class)->create(); // Create a Machine Job record

        $result = (new MachineJobRepository())->find($job->uuid, $job->user_id);

        $this->assertSame($job->uuid, $result->uuid);
        $this->assertSame($job->user_id, $result->user_id);
        $this->assertSame($job->machine_id, $result->machine_id);
        $this->assertSame($job->name, $result->name);
        $this->assertSame($job->job_id, $result->job_id);
        $this->assertSame($job->status, $result->status);
        $this->assertSame((string) $job->start, (string) $result->start);
        $this->assertSame($job->duration, $result->duration);
        $this->assertSame($job->type, $result->type);
        $this->assertSame($job->details, $result->details);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function it_can_retrieve_all_machine_jobs_of_a_user(): void
    {
        $samples = random_int(2, 50);
        $user_id = random_int(1, 20);

        $collection = factory(MachineJob::class, $samples)->create(['user_id' => $user_id]);

        $result = (new MachineJobRepository())->all($user_id, new MachineJobQueryOptions());

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($collection->count(), $result->count());
        $this->assertSame($user_id, $result->pluck('user_id')->unique()->first());
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function it_can_delete_a_machine_job_by_uuid(): void
    {
        $samples = random_int(2, 50);
        $user_id = random_int(1, 20);

        $collection = factory(MachineJob::class, $samples)->create(['user_id' => $user_id]);

        $job_id = $collection->random()->uuid;

        $repository = new MachineJobRepository();

        $result = $repository->delete($job_id, $user_id);

        $this->assertTrue($result);
        $this->assertSame($samples - 1, $repository->all($user_id, new MachineJobQueryOptions())->count());
        $this->assertNotContains($job_id, $repository->all($user_id, new MachineJobQueryOptions())->pluck('uuid'));
    }

    /**
     * @test
     */
    public function it_can_update_a_machine_job_by_uuid(): void
    {
        $job = factory(MachineJob::class)->create();

        $repository = new MachineJobRepository();

        $update['status']     = $this->faker->randomElement([MachineJobStatus::SUCCESS, MachineJobStatus::FAILED, MachineJobStatus::IN_PROGRESS]);
        $update['name']       = $this->faker->word;
        $update['started_at'] = $this->faker->dateTime();
        $update['duration']   = $this->faker->numberBetween(0, 50000);
        $update['type']       = $this->faker->randomElement([MachineJobType::THREE_D_PRINTER, MachineJobType::ROUTER, MachineJobType::LASER]);
        $update['details']    = json_encode($this->faker->shuffleArray([$this->faker->word, $this->faker->word, $this->faker->word]));

        $request = new MachineJobRequest($update);

        $repository->update($job->uuid, $job->user_id, $request);
        $result = $repository->find($job->uuid, $job->user_id);

        $this->assertSame($update['status'], $result->status);
        $this->assertSame($update['name'], $result->name);
        $this->assertSame($update['started_at']->format('Y-m-d H:i:s'), $result->started_at);
        $this->assertSame($update['duration'], $result->duration);
        $this->assertSame($update['type'], $result->type);
        $this->assertSame($update['details'], $result->details);
    }

    /**
     * @test
     */
    public function it_can_create_a_machine_job(): void
    {
        $job = factory(MachineJob::class)->create(); // Create a Machine Job record

        $repository = new MachineJobRepository();
        $jobs_count = $repository->all($job->user_id, new MachineJobQueryOptions())->count(); // Get the number of records before creation

        $request['status']     = $this->faker->randomElement([MachineJobStatus::SUCCESS, MachineJobStatus::FAILED, MachineJobStatus::IN_PROGRESS]);
        $request['job_id']     = $this->faker->ean13.'abc';
        $request['name']       = $this->faker->word;
        $request['started_at'] = $this->faker->dateTime();
        $request['duration']   = $this->faker->numberBetween(0, 50000);
        $request['type']       = $this->faker->randomElement([MachineJobType::THREE_D_PRINTER, MachineJobType::ROUTER, MachineJobType::LASER]);
        $request['machine_id'] = $this->faker->randomElement(Machine::all()->pluck('id')->toArray());
        $request['details']    = json_encode($this->faker->shuffleArray([$this->faker->word, $this->faker->word, $this->faker->word]));

        $result = $repository->store($job->user_id, new MachineJobRequest($request));

        $this->assertSame($jobs_count + 1, $repository->all($job->user_id, new MachineJobQueryOptions())->count());
        $this->assertInstanceOf(MachineJob::class, $result);
        $this->assertSame($request['name'], $result->name);
        $this->assertSame($request['status'], $result->status);
        $this->assertSame($request['started_at']->format(DateTime::ATOM), $result->started_at->format(DateTime::ATOM));
        $this->assertSame($request['duration'], $result->duration);
        $this->assertSame($request['type'], $result->type);
        $this->assertSame($request['machine_id'], $result->machine_id);
        $this->assertSame($request['details'], $result->details);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function it_can_retrieve_print_activity_of_a_user(): void
    {
        $samples = random_int(2, 50);
        $user_id = random_int(1, 20);

        factory(MachineJob::class, $samples)->create(['user_id' => $user_id]);

        $filter       = new MachineJobQueryOptions();
        $filter->type = MachineJobType::THREE_D_PRINTER;

        $result = (new MachineJobRepository())->activity($user_id, $filter);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertArrayHasKey('date', $result->toArray()[0]); // Just check first item
        $this->assertArrayHasKey('count', $result->toArray()[0]);
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function it_can_retrieve_print_job_success_rate_of_a_user(): void
    {
        $samples = random_int(2, 50);
        $user_id = random_int(1, 20);

        factory(MachineJob::class, $samples)->create(['user_id' => $user_id, 'type' => MachineJobType::THREE_D_PRINTER]);

        $filter       = new MachineJobQueryOptions();
        $filter->type = MachineJobType::THREE_D_PRINTER;

        $result = (new MachineJobRepository())->success_rate($user_id, $filter);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertArrayHasKey('status', $result->toArray()[0]); // Just check first item
        $this->assertArrayHasKey('value', $result->toArray()[0]);
    }
}

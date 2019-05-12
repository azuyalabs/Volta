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

namespace App\Repositories;

use App\MachineJob;
use App\MachineJobStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\MachineJob as MachineJobRequest;
use App\Contracts\Repositories\MachineJobRepository as Contract;

/**
 * The Machine Job Repository with Eloquent as the data backend.
 *
 * @package App\Repositories
 */
class MachineJobRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function all($type, $user_id): Collection
    {
        return MachineJob::whereUserId($user_id)
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })->with('machine')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id, $user_id): bool
    {
        return $this->find($id, $user_id)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $user_id): MachineJob
    {
        return MachineJob::whereUserId($user_id)->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $user_id, MachineJobRequest $request): bool
    {
        return $this->find($id, $user_id)->update($request->all());
    }

    /**
     * {@inheritdoc}
     */
    public function store($user_id, MachineJobRequest $request): MachineJob
    {
        $requestData = $request->all();
        $requestData = \array_merge($requestData, ['user_id' => $user_id]);

        return MachineJob::create($requestData);
    }

    /**
     * {@inheritdoc}
     */
    public function activity($type, $user_id): Collection
    {
        return MachineJob::select(DB::raw('date(started_at) as date, count(job_id) as count'))
            ->whereUserId($user_id)
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->whereIn('status', [MachineJobStatus::FAILED, MachineJobStatus::SUCCESS])
            ->groupBy('date')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function success_rate($type, $user_id): Collection
    {
        return MachineJob::select(DB::raw('status, count(job_id) as value'))
            ->whereUserId($user_id)
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->whereIn('status', [MachineJobStatus::FAILED, MachineJobStatus::SUCCESS])
            ->groupBy('status')
            ->get();
    }
}

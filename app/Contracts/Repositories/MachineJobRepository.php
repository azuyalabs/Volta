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

namespace App\Contracts\Repositories;

use App\Http\Requests\MachineJob as MachineJobRequest;
use App\MachineJob;
use App\QueryOptions\MachineJobQueryOptions;
use Illuminate\Database\Eloquent\Collection;

/**
 * Machine Job Repository contract.
 */
interface MachineJobRepository
{
    /**
     * Get all of the authenticated user's machine jobs.
     *
     * @param MachineJobQueryOptions $options query options
     * @param int                    $user_id the identifier of the user owning the machine jobs
     */
    public function all($user_id, MachineJobQueryOptions $options): Collection;

    /**
     * Retrieves a machine job from storage with the given ID.
     *
     * @param string $id      the machine job identifier
     * @param int    $user_id the identifier of the user owning this machine job
     */
    public function find($id, $user_id): MachineJob;

    /**
     * Removes a machine job from storage with the given ID.
     *
     * @param string $id      the machine job identifier
     * @param int    $user_id the identifier of the user owning this machine job
     *
     * @return bool true if removal was successful, false otherwise
     */
    public function delete($id, $user_id): bool;

    /**
     * Updates a machine job from storage with the given ID.
     *
     * @param string            $id      the filament spool identifier
     * @param int               $user_id the identifier of the user owning this machine job
     * @param MachineJobRequest $request the Form Request containing the updated machine job data
     *
     * @return bool true if update was successful, false otherwise
     */
    public function update($id, $user_id, MachineJobRequest $request): bool;

    /**
     * Adds a machine job to the storage.
     *
     * @param int $user_id the identifier of the user creating this machine job
     *
     * @return MachineJob the newly created Machine Job object
     */
    public function store($user_id, MachineJobRequest $request): MachineJob;

    /**
     * Gets all of machine jobs activity (summary) of the given user.
     *
     * @param MachineJobQueryOptions $options query options
     * @param int                    $user_id the identifier of the user owning the machine jobs
     */
    public function activity($user_id, MachineJobQueryOptions $options): Collection;

    /**
     * Get the success rate (success vs failure ration) of all machine jobs of the given user.
     *
     * @param MachineJobQueryOptions $options query options
     * @param int                    $user_id the identifier of the user owning the machine jobs
     */
    public function success_rate($user_id, MachineJobQueryOptions $options): Collection;
}

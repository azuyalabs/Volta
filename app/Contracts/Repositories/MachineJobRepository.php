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

namespace App\Contracts\Repositories;

use App\MachineJob;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\MachineJob as MachineJobRequest;

/**
 * Machine Job Repository contract.
 *
 * @package App\Contracts\Repositories
 */
interface MachineJobRepository
{
    /**
     * Get all of the authenticated user's machine jobs.
     *
     * @param  string|null $type the type of machine
     * @param int $user_id the identifier of the user owning the machine jobs
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($type, $user_id): Collection;

    /**
     * Retrieves a machine job from storage with the given ID.
     *
     * @param string $id the machine job identifier
     * @param int $user_id the identifier of the user owning this machine job
     *
     * @return MachineJob
     */
    public function find($id, $user_id): MachineJob;

    /**
     * Removes a machine job from storage with the given ID
     *
     * @param string $id the machine job identifier
     * @param int $user_id the identifier of the user owning this machine job
     *
     * @return boolean true if removal was successful, false otherwise
     */
    public function delete($id, $user_id): bool;

    /**
     * Updates a machine job from storage with the given ID
     *
     * @param string $id the filament spool identifier
     * @param int $user_id the identifier of the user owning this machine job
     * @param MachineJobRequest $request the Form Request containing the updated machine job data
     *
     * @return boolean true if update was successful, false otherwise
     */
    public function update($id, $user_id, MachineJobRequest $request): bool;

    /**
     * Adds a machine job to the storage
     *
     * @param int $user_id the identifier of the user creating this machine job
     * @param MachineJobRequest $request
     *
     * @return MachineJob the newly created Machine Job object
     */
    public function store($user_id, MachineJobRequest $request): MachineJob;

    /**
     * Gets all of machine jobs activity (summary) of the given user
     *
     * @param  string|null $type the type of machine
     * @param int $user_id the identifier of the user owning the machine jobs
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activity($type, $user_id): Collection;

    /**
     * Get the success rate (success vs failure ration) of all machine jobs of the given user
     *
     * @param  string|null $type the type of machine
     * @param int $user_id the identifier of the user owning the machine jobs
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function success_rate($type, $user_id): Collection;
}

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

use App\FilamentSpool;
use Illuminate\Support\Collection;
use App\Http\Requests\FilamentSpool as FilamentSpoolRequest;

/**
 * Filament Spool Repository contract.
 *
 * @package App\Contracts\Repositories
 */
interface FilamentSpoolRepository
{
    /**
     * Get all of the authenticated user's filament spools.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Retrieves a filament spool from storage with the given ID.
     *
     * @param string $id the filament spool identifier
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Creates a new filament spool in storage
     *
     * @param FilamentSpoolRequest $request the Form Request containing the new filament spool data
     *
     * @return FilamentSpool the newly created Filament Spool object
     */
    public function create(FilamentSpoolRequest $request): FilamentSpool;

    /**
     * Removes a filament spool from storage with the given ID
     *
     * @param string $id the filament spool identifier
     *
     * @return boolean true if removal was successful, false otherwise
     */
    public function delete($id): bool;

    /**
     * Updates a filament spool from storage with the given ID
     *
     * @param string $id the filament spool identifier
     * @param FilamentSpoolRequest $request the Form Request containing the updated filament spool data
     *
     * @return boolean true if update was successful, false otherwise
     */
    public function update($id, FilamentSpoolRequest $request): bool;

    /**
     * Gets a summary (statistics) of the authenticated user's filament spools.
     *
     * @return array list of performance indicators of the of the authenticated user's filament spools.
     */
    public function summary(): array;

    /**
     * Duplicate the specified filament spool in storage.
     *
     * @param string $id the id of the filament spool
     *
     * @return boolean true if duplication was successful, false otherwise
     */
    public function duplicate($id): bool;

    /**
     * Mark the specified filament spool in storage as empty (i.e. all filament is consumed_.
     *
     * @param string $id the id of the filament spool
     *
     * @return boolean true if the update was successful, false otherwise
     */
    public function markAsEmpty($id): bool;
}

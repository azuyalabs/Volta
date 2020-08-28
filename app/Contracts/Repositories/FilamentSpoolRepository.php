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

use App\FilamentSpool;
use App\Http\Requests\FilamentSpool as FilamentSpoolRequest;
use Illuminate\Support\Collection;

/**
 * Filament Spool Repository contract.
 */
interface FilamentSpoolRepository
{
    /**
     * Get all of the authenticated user's filament spools.
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
     * Creates a new filament spool in storage.
     *
     * @param FilamentSpoolRequest $request the Form Request containing the new filament spool data
     *
     * @return FilamentSpool the newly created Filament Spool object
     */
    public function create(FilamentSpoolRequest $request): FilamentSpool;

    /**
     * Removes a filament spool from storage with the given ID.
     *
     * @param string $id the filament spool identifier
     *
     * @return bool true if removal was successful, false otherwise
     */
    public function delete($id): bool;

    /**
     * Updates a filament spool from storage with the given ID.
     *
     * @param string               $id      the filament spool identifier
     * @param FilamentSpoolRequest $request the Form Request containing the updated filament spool data
     *
     * @return bool true if update was successful, false otherwise
     */
    public function update($id, FilamentSpoolRequest $request): bool;

    /**
     * Gets a summary (statistics) of the authenticated user's filament spools.
     *
     * @return array list of performance indicators of the of the authenticated user's filament spools
     */
    public function summary(): array;

    /**
     * Duplicate the specified filament spool in storage.
     *
     * @param string $id the id of the filament spool
     *
     * @return bool true if duplication was successful, false otherwise
     */
    public function duplicate($id): bool;

    /**
     * Mark the specified filament spool in storage as empty (i.e. all filament is consumed_.
     *
     * @param string $id the id of the filament spool
     *
     * @return bool true if the update was successful, false otherwise
     */
    public function markAsEmpty($id): bool;
}

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

use App\Http\Requests\ManufacturerRequest as ManufacturerRequest;
use App\Manufacturer;
use App\QueryOptions\ManufacturerQueryOptions;
use Illuminate\Database\Eloquent\Collection;

/**
 * Manufacturer Repository contract.
 */
interface ManufacturerRepository
{
    /**
     * Get all of the manufacturers.
     *
     * @param ManufacturerQueryOptions $options query options
     */
    public function all(ManufacturerQueryOptions $options): Collection;

    /**
     * Removes a manufacturer from storage with the given ID.
     *
     * @param string $id the manufacturer identifier
     *
     * @return bool true if removal was successful, false otherwise
     */
    public function delete($id): bool;

    /**
     * Adds a new manufacturer to the storage.
     *
     * @return Manufacturer the newly created Machine Job object
     */
    public function create(ManufacturerRequest $request): Manufacturer;

    /**
     * Updates a manufacturer from storage with the given ID.
     *
     * @param string              $id      the manufacturer identifier
     * @param ManufacturerRequest $request the Form Request containing the updated manufacturer data
     *
     * @return bool true if update was successful, false otherwise
     */
    public function update($id, ManufacturerRequest $request): bool;
}

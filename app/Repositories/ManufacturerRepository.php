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

namespace App\Repositories;

use App\Contracts\Repositories\ManufacturerRepository as Contract;
use App\Http\Requests\ManufacturerRequest as ManufacturerRequest;
use App\Manufacturer;
use App\QueryOptions\ManufacturerQueryOptions;
use Illuminate\Database\Eloquent\Collection;

/**
 * The Manufacturer Repository with Eloquent as the data backend.
 */
class ManufacturerRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function all(ManufacturerQueryOptions $options): Collection
    {
        return Manufacturer::withQueryOptions($options)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): Manufacturer
    {
        return Manufacturer::where((new Manufacturer())->getRouteKeyName(), $id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(ManufacturerRequest $request): Manufacturer
    {
        $requestData = $request->all();

        return Manufacturer::create($requestData);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, ManufacturerRequest $request): bool
    {
        return $this->find($id)->update($request->all());
    }
}

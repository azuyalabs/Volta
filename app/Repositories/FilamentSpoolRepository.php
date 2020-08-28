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

use App\Contracts\Repositories\FilamentSpoolRepository as Contract;
use App\FilamentSpool;
use App\Http\Requests\FilamentSpool as FilamentSpoolRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * The Filament Spool Repository with Eloquent as the data backend.
 */
class FilamentSpoolRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function all(): Collection
    {
        return FilamentSpool::whereUserId(auth()->user()->id)->with('manufacturer')->get();
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
    public function find($id)
    {
        return FilamentSpool::whereUserId(auth()->user()->id)->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, FilamentSpoolRequest $request): bool
    {
        return $this->find($id)->update($request->all());
    }

    /**
     * {@inheritdoc}
     */
    public function create(FilamentSpoolRequest $request): FilamentSpool
    {
        $requestData = $request->all();
        $requestData = array_merge($requestData, ['user_id' => auth()->user()->id]);

        return FilamentSpool::create($requestData);
    }

    /**
     * {@inheritdoc}
     */
    public function summary(): array
    {
        $summary = FilamentSpool::whereUserId(auth()->user()->id)
            ->select(
                [
                    DB::raw('COUNT(id) as count'),
                    DB::raw('SUM(weight) as weight_total'),
                    DB::raw('SUM(purchase_price) as price_total'),
                ]
            )->get();

        $statistics['count']  = $summary[0]->count ?? 0;
        $statistics['weight'] = (int) ($summary[0]->weight_total ?? 0);
        $statistics['value']  = (float) ($summary[0]->price_total ?? 0);

        return $statistics;
    }

    /**
     * {@inheritdoc}
     */
    public function duplicate($id): bool
    {
        $spool = $this->find($id);

        $replica        = $spool->replicate();
        $replica->usage = 0;

        return $replica->save();
    }

    /**
     * {@inheritdoc}
     */
    public function markAsEmpty($id): bool
    {
        $spool = $this->find($id);
        $spool->markAsEmpty();

        unset($spool->length); // Need to unset this, otherwise Eloquent tries to update it (??)

        return $spool->save();
    }
}

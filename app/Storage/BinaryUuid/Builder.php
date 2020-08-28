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

namespace App\Storage\BinaryUuid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Builder extends EloquentBuilder
{
    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @param array $columns
     *
     * @return null|Collection|Model|static|static[]
     */
    public function find($id, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            return $this->findMany($id, $columns);
        }

        return $this->withUuid($id)->first($columns);
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param array|Arrayable $ids
     * @param array           $columns
     *
     * @return Collection
     */
    public function findMany($ids, $columns = ['*'])
    {
        if (empty($ids)) {
            return $this->model->newCollection();
        }

        return $this->withUuid($ids)->get($columns);
    }
}

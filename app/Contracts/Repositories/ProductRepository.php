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

use Illuminate\Database\Eloquent\Collection;

/**
 * ProductRepository interface.
 */
interface ProductRepository
{
    /**
     * Get all of the products for the application.
     *
     * @return Collection
     */
    public function all();
}

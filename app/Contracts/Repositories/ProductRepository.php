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

/**
 * ProductRepository interface
 *
 * @package App\Contracts\Repositories
 */
interface ProductRepository
{
    /**
     * Get all of the products for the application.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
}

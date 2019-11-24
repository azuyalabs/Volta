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

namespace App\Repositories;

use Punic\Territory;
use App\Contracts\Repositories\CountryRepository as Contract;

class CountryRepository implements Contract
{

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return Territory::getCountries();
    }

    public function getName($code)
    {
        return Territory::getName($code);
    }
}

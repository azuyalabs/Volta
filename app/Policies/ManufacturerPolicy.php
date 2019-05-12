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

namespace App\Policies;

use App\User;
use App\Manufacturer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManufacturerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a manufacturer.
     *
     * @param  \App\User $user
     * @param  \App\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function view(User $user, Manufacturer $manufacturer)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can create a manufacturer.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can update a manufacturer.
     *
     * @param  \App\User $user
     * @param  \App\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function update(User $user, Manufacturer $manufacturer)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can delete a manufacturer.
     *
     * @param  \App\User $user
     * @param  \App\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function delete(User $user, Manufacturer $manufacturer)
    {
        return $user->isAdministrator();
    }

    public function list(User $user)
    {
        return true;
    }
}
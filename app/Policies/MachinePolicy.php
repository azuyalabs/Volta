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

namespace App\Policies;

use App\Machine;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Authorization Policy for Equipment.
 */
class MachinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of machines.
     *
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the machine.
     *
     * @return mixed
     */
    public function view(User $user, Machine $machine)
    {
        return $user->id === $machine->user_id;
    }

    /**
     * Determine whether the user can create machines.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('experimental');
    }

    /**
     * Determine whether the user can update the machine.
     *
     * @return mixed
     */
    public function update(User $user, Machine $machine)
    {
        return $user->id === $machine->user_id;
    }

    /**
     * Determine whether the user can delete the machine.
     *
     * @return mixed
     */
    public function delete(User $user, Machine $machine)
    {
        return $user->id === $machine->user_id;
    }
}

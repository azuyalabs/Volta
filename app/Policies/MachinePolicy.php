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
use App\Machine;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Authorization Policy for Equipment
 *
 * @package App\Policies
 */
class MachinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine to authorize an action before the intended policy method is called.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function before($user)
    {
        if ($user->isAdministrator()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the list of machines.
     *
     * @param  \App\User $user
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
     * @param  \App\User $user
     * @param  \App\Machine $machine
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
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the machine.
     *
     * @param  \App\User $user
     * @param  \App\Machine $machine
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
     * @param  \App\User $user
     * @param  \App\Machine $machine
     *
     * @return mixed
     */
    public function delete(User $user, Machine $machine)
    {
        return $user->id === $machine->user_id;
    }
}

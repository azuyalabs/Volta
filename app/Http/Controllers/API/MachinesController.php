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

namespace App\Http\Controllers\API;

use App\Machine;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MachineResource;
use App\Http\Resources\MachineCollectionResource;

class MachinesController extends Controller
{
    /**
     * Display the specified machine.
     *
     * @param  \App\Machine $machine
     *
     * @return \App\Http\Resources\MachineResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Machine $machine): MachineResource
    {
        $this->authorize('view', $machine);

        MachineResource::withoutWrapping();

        return new MachineResource($machine);
    }

    /**
     * Display a listing of a user's machines.
     *
     * @return \App\Http\Resources\MachineCollectionResource
     */
    public function index(): MachineCollectionResource
    {
        return new MachineCollectionResource(Machine::where('user_id', Auth::guard()->user()->id)->get());
    }

    /**
     * Remove the specified machine from storage.
     *
     * @param  Machine $machine
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Machine $machine): Response
    {
        $this->authorize('delete', $machine);

        $machine->delete();

        return response(null, Response::HTTP_OK);
    }
}

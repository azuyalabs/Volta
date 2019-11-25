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

use Exception;
use App\Machine;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MachineResource;
use App\Http\Resources\MachineCollectionResource;
use Illuminate\Auth\Access\AuthorizationException;

class MachinesController extends Controller
{
    /**
     * Display the specified machine.
     *
     * @param Machine $machine
     *
     * @return MachineResource
     *
     * @throws AuthorizationException
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
     * @return MachineCollectionResource
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
     * @return Response
     * @throws Exception
     */
    public function destroy(Machine $machine): Response
    {
        $this->authorize('delete', $machine);

        $machine->delete();

        return response(null, Response::HTTP_OK);
    }
}
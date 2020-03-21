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

use App\GCode;
use App\Http\Resources\MachineCollectionResource;
use App\Http\Resources\PrintJobResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class PrintJobsController extends Controller
{

    /**
     * Display the specified print job.
     *
     * @param  string $printJob
     *
     * @return PrintJobResource
     *
     * @throws AuthorizationException
     */
    public function show(string $printJob): PrintJobResource
    {
        $this->authorize('view', $printJob);

        $gcode = new GCode(Storage::disk('gcode')->path($printJob));

        PrintJobResource::withoutWrapping();

        return new PrintJobResource($gcode);
    }

    /**
     * Display a listing of a user's machines.
     *
     * @return MachineCollectionResource
     */
    //public function index()
    //{
    //     return ['dadas', 'dads'];
    //     //return new MachineCollectionResource(Machine::where('user_id', Auth::guard()->user()->id)->get());
    // }
}

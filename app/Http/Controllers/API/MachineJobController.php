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

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Contracts\Repositories\MachineJobRepository;
use App\Http\Requests\MachineJob as MachineJobRequest;
use App\Http\Resources\ThreeDPrinterJobCollectionResource;

abstract class MachineJobController extends Controller
{
    /**
     * API MachineJobController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * List the machine jobs of the given type.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Contracts\Repositories\MachineJobRepository $storage
     * @return \App\Http\Resources\ThreeDPrinterJobCollectionResource
     */
    public function index(Request $request, MachineJobRepository $storage): ThreeDPrinterJobCollectionResource
    {
        return new ThreeDPrinterJobCollectionResource($storage->all($this->machineType(), auth()->user()->id));
    }

    /**
     * The machine type for the controller.
     *
     * @return string
     */
    abstract protected function machineType();

    /**
     * Remove the specified machine job from storage.
     *
     * @param string $id the id of the machine job
     *
     * @param MachineJobRepository $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, MachineJobRepository $storage): Response
    {
        if ($storage->delete($id, auth()->user()->id)) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Update the specified machine job in storage.
     *
     * @param string $id the id of the machine job
     * @param MachineJobRepository $storage
     * @param MachineJobRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, MachineJobRepository $storage, MachineJobRequest $request): Response
    {
        if ($storage->update($id, auth()->user()->id, $request)) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Add a new machine job to the storage
     *
     * @param MachineJobRequest $request
     * @param MachineJobRepository $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MachineJobRequest $request, MachineJobRepository $storage)
    {
        $storage->store(auth()->user()->id, $request);

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }

    /**
     * Retrieves all the print job activity of the given user.
     *
     * @param MachineJobRepository $storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function activity(MachineJobRepository $storage)
    {
        $activity = $storage->activity($this->machineType(), auth()->user()->id);

        return response()->json($activity);
    }

    /**
     * Retrieves the success rate of all print jobs over time of the given user.
     *
     * @param MachineJobRepository $storage
     * @return \Illuminate\Http\JsonResponse
     */
    public function success_rate(MachineJobRepository $storage)
    {
        $activity = $storage->success_rate($this->machineType(), auth()->user()->id);

        return response()->json($activity);
    }
}

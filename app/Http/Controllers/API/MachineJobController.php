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

use App\MachineJobStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\QueryOptions\MachineJobQueryOptions;
use App\Contracts\Repositories\MachineJobRepository;
use App\Http\Requests\MachineJob as MachineJobRequest;
use App\Http\Resources\ThreeDPrinterJobCollectionResource;

abstract class MachineJobController extends Controller
{
    /**
     * List the machine jobs of the given type.
     *
     * @param Request $request
     * @param MachineJobRepository $storage
     * @return ThreeDPrinterJobCollectionResource
     */
    public function index(Request $request, MachineJobRepository $storage): ThreeDPrinterJobCollectionResource
    {
        $options = new MachineJobQueryOptions();
        $options->type($this->machineType());

        return new ThreeDPrinterJobCollectionResource($storage->all(auth()->user()->id, $options));
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
     * @return Response
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
     * @return Response
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
     * Retrieves all the print job activity of the given user for the last year.
     *
     * @param MachineJobRepository $storage
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function activity(MachineJobRepository $storage)
    {
        $options = new MachineJobQueryOptions();
        $options->statuses([MachineJobStatus::FAILED, MachineJobStatus::SUCCESS]);
        $options->type($this->machineType());

        $endDate = new \DateTimeImmutable();
        $options->start_date_period(new \DatePeriod(
            $endDate->sub(new \DateInterval('P1Y')),
            new \DateInterval('P1D'),
            $endDate
        ));

        $activity = $storage->activity(auth()->user()->id, $options);

        return response()->json($activity);
    }

    /**
     * Retrieves the success rate of all print jobs over time of the given user.
     *
     * @param MachineJobRepository $storage
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function success_rate(MachineJobRepository $storage)
    {
        $options = new MachineJobQueryOptions();
        $options->statuses([MachineJobStatus::FAILED, MachineJobStatus::SUCCESS]);
        $options->type($this->machineType());

        $endDate = new \DateTimeImmutable();
        $options->start_date_period(new \DatePeriod(
            $endDate->sub(new \DateInterval('P1Y')),
            new \DateInterval('P1D'),
            $endDate
        ));

        $activity = $storage->success_rate(auth()->user()->id, $options);

        return response()->json($activity);
    }
}

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
use App\Rules\ValidPrinterId;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Resources\VerificationResource;
use App\Events\PrinterMonitor\PrinterStatusFetched;

/**
 * Class PrinterController
 *
 * @package App\Http\Controllers\API
 */
class PrinterController extends Controller
{

    /**
     * PrintJobsController constructor.
     */
    public function __construct()
    {
        $this->middleware('octoprintclient');
    }

    /**
     * Verifies the OctoPrint Client
     *
     * @return VerificationResource
     */
    public function verify()
    {
        VerificationResource::withoutWrapping();

        return new VerificationResource(auth()->user());
    }

    /**
     * Accepts updates to a registered printer via the OctoPrint plugin.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function monitor(Request $request)
    {
        // Create a ValidPrinterId rule instance
        $validPrinterIdRule = new ValidPrinterId(auth()->user()->api_token);

        // Validate the submitted data
        $validatedData = $request->validate(
            [
                'id'    => ['required', 'string', 'max:100', $validPrinterIdRule],
                'name'  => 'required|string',
                'state' => 'required|string',

                'extruder_temperature.current' => 'numeric|min:0|max:300',
                'heatbed_temperature.current'  => 'numeric|min:0|max:150',

                'extruder_temperature.target' => 'numeric|min:0|max:300',
                'heatbed_temperature.target'  => 'numeric|min:0|max:150',

                'printjob.filename'        => 'nullable|string',
                'printjob.time_elapsed'    => 'numeric|min:0',
                'printjob.time_remaining'  => 'numeric|min:0',
                'printjob.progress'        => 'integer|min:0|max:100',
                'printjob.filament_length' => 'numeric|min:0',
                'printjob.started_at'      => 'string',
                'printjob.status'          => 'string'
            ]
        );

        $validatedData['printer'] = $validPrinterIdRule->printerId;

        // Broadcast printer state and return response
        event(new PrinterStatusFetched($validatedData));

        return response()->json([
            'status'  => 'ok',
            'message' => sprintf('Data for printer `%s` successfully received.', $validPrinterIdRule->printerId)
        ], 201);
    }
}

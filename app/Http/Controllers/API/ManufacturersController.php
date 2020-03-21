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

use App\Contracts\Repositories\ManufacturerRepository;
use App\Http\Requests\ManufacturerRequest as ManufacturerRequest;
use App\Http\Resources\ManufacturerCollectionResource;
use App\Http\Resources\ManufacturerResource;
use App\Manufacturer;
use App\QueryOptions\ManufacturerQueryOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManufacturersController extends Controller
{
    /**
     *List all manufacturers.
     *
     * @param Request $request
     * @param ManufacturerRepository $storage
     * @return ManufacturerCollectionResource
     */
    public function index(Request $request, ManufacturerRepository $storage): ManufacturerCollectionResource
    {
        return new ManufacturerCollectionResource($storage->all(new ManufacturerQueryOptions()));
    }

    /**
     * Store a new manufacturer
     *
     * @param ManufacturerRequest $request
     * @return JsonResponse
     */
    public function store(ManufacturerRequest $request)
    {
        Manufacturer::firstOrCreate($request->validated());

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Remove the specified manufacturer from storage
     *
     * @param string $id the id of the manufacturer
     *
     * @param ManufacturerRepository $storage
     * @return Response
     */
    public function destroy($id, ManufacturerRepository $storage): Response
    {
        if ($storage->delete($id)) {
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Get the specified manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return ManufacturerResource
     */
    public function show(Manufacturer $manufacturer)
    {
        return new ManufacturerResource($manufacturer);
    }

    /**
     * Update the specified manufacturer
     *
     * @param ManufacturerRequest $request
     * @param Manufacturer $manufacturer
     *
     * @return JsonResponse
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        unset($request['id']); // Route Key is not the primary key

        $manufacturer->fill($request->toArray())->save();

        return response()->json(['success' => true], Response::HTTP_OK);
    }
}

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

use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerResource;
use App\Http\Resources\ManufacturerCollectionResource;
use App\Http\Requests\Manufacturer as ManufacturerRequest;

class ManufacturersController extends Controller
{
    /**
     * MachinesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        //$this->authorizeResource(Manufacturer::class);
    }

    /**
     * Get a list of all manufacturers.
     *
     * @param Request $request
     * @return \App\Http\Resources\ManufacturerCollectionResource
     */
    public function index(Request $request): ManufacturerCollectionResource
    {
        $collection = Manufacturer::query();

        if ($request->has('filter') && null !== $request->query('filter')) {
            $collection->where('name', 'LIKE', '%' . $request->query('filter') . '%');
        }

        if ($request->has('sort') && null !== $request->query('sort')) {
            [$sort_field, $sort_direction] = \explode('|', $request->query('sort'));

            $collection->orderBy($sort_field, $sort_direction);
        }

        return new ManufacturerCollectionResource($collection->paginate(10));
    }

    /**
     * Store a new manufacturer
     *
     * @param ManufacturerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ManufacturerRequest $request)
    {
        Manufacturer::firstOrCreate($request->validated());

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Remove the specified manufacturer
     *
     * @param  Manufacturer $manufacturer
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Manufacturer $manufacturer): Response
    {
        $manufacturer->delete();

        return response(null, Response::HTTP_OK);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        unset($request['id']); // Route Key is not the primary key

        $manufacturer->fill($request->toArray())->save();

        return response()->json(['success' => true], Response::HTTP_OK);
    }
}

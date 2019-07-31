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

use App\Product;
use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product as ProductRequest;
use App\Http\Resources\ProductCollectionResource;

class ProductsController extends Controller
{

    /**
     * Get a list of all products.
     *
     * @param Request $request
     * @return ProductCollectionResource
     */
    public function index(Request $request): ProductCollectionResource
    {
        $collection = Product::query();

        if ($request->has('filter') && null !== $request->query('filter')) {
            $collection->where('name', 'LIKE', '%' . $request->query('filter') . '%');
        }

        if ($request->has('sort') && null !== $request->query('sort')) {
            [$sort_field, $sort_direction] = \explode('|', $request->query('sort'));

            $collection->orderBy($sort_field, $sort_direction);
        }

        return new ProductCollectionResource($collection->paginate(10));
    }

    /**
     * Store a new product
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;
        $product->manufacturer()->associate(Manufacturer::findBySlug($request['manufacturer']));
        $product->fill($request->validated())->save();

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Remove the specified product
     *
     * @param  Product $product
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Get the specified product
     *
     * @param Product $product
     *
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified product
     *
     * @param ProductRequest $request
     * @param Product $product
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->manufacturer()->associate(Manufacturer::findBySlug($request['manufacturer']));
        $product->fill($request->toArray())->save();

        return response()->json(['success' => true], Response::HTTP_OK);
    }
}

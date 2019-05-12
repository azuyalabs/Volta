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

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilamentSpoolResource;
use App\Contracts\Repositories\FilamentSpoolRepository;
use App\Http\Resources\FilamentSpoolCollectionResource;

class FilamentSpoolsController extends Controller
{
    /**
     * @var FilamentSpoolRepository $spools the Filament Spools Repository
     */
    private $spools;

    /**
     * API FilamentSpoolsController constructor.
     *
     * @param FilamentSpoolRepository $spools
     *
     */
    public function __construct(FilamentSpoolRepository $spools)
    {
        $this->spools = $spools;

        $this->middleware('auth:api');
    }

    /**
     * Return the specified filament spool.
     *
     * @param string $id the id of the filament spool
     *
     * @return \App\Http\Resources\FilamentSpoolResource
     */
    public function show($id): FilamentSpoolResource
    {
        FilamentSpoolResource::withoutWrapping();

        return new FilamentSpoolResource($this->spools->find($id));
    }

    /**
     * Return a listing of the authenticated users' filament spools.
     *
     * @return \App\Http\Resources\FilamentSpoolCollectionResource
     */
    public function index(): FilamentSpoolCollectionResource
    {
        return new FilamentSpoolCollectionResource($this->spools->all());
    }

    /**
     * Remove the specified filament spool from storage.
     *
     * @param string $id the id of the filament spool
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): Response
    {
        if ($this->spools->delete($id)) {
            return response(null, Response::HTTP_OK);
        }
    }
}

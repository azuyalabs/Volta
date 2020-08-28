<?php

declare(strict_types=1);
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

use App\Contracts\Repositories\FilamentSpoolRepository;
use App\Http\Resources\FilamentSpoolCollectionResource;
use App\Http\Resources\FilamentSpoolResource;
use Illuminate\Http\Response;

class FilamentSpoolsController extends Controller
{
    /**
     * @var FilamentSpoolRepository the Filament Spools Repository
     */
    private $spools;

    /**
     * API FilamentSpoolsController constructor.
     */
    public function __construct(FilamentSpoolRepository $spools)
    {
        parent::__construct();
        $this->spools = $spools;
    }

    /**
     * Return the specified filament spool.
     *
     * @param string $id the id of the filament spool
     */
    public function show($id): FilamentSpoolResource
    {
        FilamentSpoolResource::withoutWrapping();

        return new FilamentSpoolResource($this->spools->find($id));
    }

    /**
     * Return a listing of the authenticated users' filament spools.
     */
    public function index(): FilamentSpoolCollectionResource
    {
        return new FilamentSpoolCollectionResource($this->spools->all());
    }

    /**
     * Remove the specified filament spool from storage.
     *
     * @param string $id the id of the filament spool
     */
    public function destroy($id): Response
    {
        if ($this->spools->delete($id)) {
            return response(null, Response::HTTP_OK);
        }
    }
}

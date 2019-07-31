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

namespace App\Http\Controllers;

use App\Manufacturer;
use App\FilamentSpool;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Repositories\FilamentSpoolRepository;
use Illuminate\Database\Eloquent\JsonEncodingException;
use App\Http\Requests\FilamentSpool as FilamentSpoolRequest;

/**
 * Controller handling the management of filament spools
 *
 * @package App\Http\Controllers
 */
class FilamentSpoolsController extends Controller
{
    /**
     * @var FilamentSpoolRepository $spools the Filament Spools Repository
     */
    private $spools;

    /**
     * FilamentSpoolsController constructor.
     *
     * @param FilamentSpoolRepository $spools
     */
    public function __construct(FilamentSpoolRepository $spools)
    {
        parent::__construct();
        $this->spools = $spools;
    }

    /**
     * Display a listing of filament spools.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        $statistics = \json_decode($this->statistics()->content());

        return view('spools.index', ['statistics' => $statistics]);
    }

    /**
     * Gets a summary (statistics) of the authenticated user's filament spools.
     *
     * @return JsonResponse
     */
    public function statistics()
    {
        return response()->json($this->spools->summary(), 200);
    }

    /**
     * Show the form for creating a new filament spool.
     *
     * @return View
     */
    public function create()
    {
        return view('spools.create', [
            'spool_manufacturers' => Manufacturer::IsFilamentSupplier()->orderBy('name', 'asc')->get()->pluck('name', 'id')
        ]);
    }

    /**
     * Show the form for editing the specified filament spool.
     *
     * @param string $id the id of the filament spool
     *
     * @return View
     */
    public function edit($id)
    {
        return view('spools.edit', [
            'spool' => $this->spools->find($id),
            'spool_manufacturers' => Manufacturer::IsFilamentSupplier()->orderBy('name', 'asc')->get()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created spool in storage.
     *
     * @param FilamentSpoolRequest $request
     *
     * @return RedirectResponse
     */
    public function store(FilamentSpoolRequest $request)
    {
        $this->spools->create($request);

        return redirect('spools')->with('success', 'The filament spool has been added successfully');
    }

    /**
     * Display the specified filament spool.
     *
     * @param string $id the id of the filament spool
     *
     * @return View
     */
    public function show($id)
    {
        return view('spools.show', ['spool' => $this->spools->find($id)]);
    }

    /**
     * Update the specified filament spool in storage.
     *
     * @param FilamentSpoolRequest $request
     * @param string $id the id of the filament spool
     *
     * @return RedirectResponse
     */
    public function update($id, FilamentSpoolRequest $request)
    {
        if ($this->spools->update($id, $request)) {
            return redirect('spools/' . $id)->with('success', 'The filament spool has been updated successfully');
        }
    }

    /**
     * Remove the specified filament spool from storage.
     *
     * @param string $id the id of the filament spool
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->spools->delete($id)) {
            return redirect('spools')->with('success', 'The filament spool has been deleted successfully');
        }
    }

    /**
     * Duplicate the specified filament spool in storage.
     *
     * @param string $id the id of the filament spool
     *
     * @return RedirectResponse
     */
    public function duplicate($id)
    {
        if ($this->spools->duplicate($id)) {
            return redirect('spools')->with('success', 'The filament spool has been duplicated successfully');
        }
    }

    /**
     * Mark the specified filament spool in storage as empty (i.e. all filament is consumed).
     *
     * @param string $id the id of the filament spool
     *
     * @return RedirectResponse
     */
    public function empty($id)
    {
        if ($this->spools->markAsEmpty($id)) {
            return redirect('spools')->with('success', 'The filament spool is now empty');
        }
    }

    /**
     * Exports the specified filament spool as a json file
     *
     * @param FilamentSpool $spool
     *
     * @return Response
     *
     * @throws JsonEncodingException
     */
    public function export(FilamentSpool $spool)
    {
        $filename = \strtolower(
            \str_replace(
                ' ',
                '',
                $spool->manufacturer->name
            ) . '_' . $spool->material . '_' . $spool->color . '.json'
        );

        return response($spool->toJson(JSON_PRETTY_PRINT))->header(
            'Content-Type',
            'application/json'
        )->header(
            'Content-Disposition',
            'attachment; filename="' . $filename . '"'
        )->header('Pragma', 'no-cache')->header('Expires', '0');
    }
}

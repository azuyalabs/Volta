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
use Illuminate\Http\Request;
use App\Repositories\CountryRepository;
use App\Repositories\ManufacturerRepository;
use App\Http\Requests\Manufacturer as ManufacturerRequest;

/**
 * Controller handling the management of manufacturers
 *
 * @package App\Http\Controllers
 */
class ManufacturersController extends Controller
{
    /**
     * @var ManufacturerRepository $spools the Filament Spools Repository
     */
    private $manufacturers;

    /**
     * ManufacturersController constructor.
     *
     * @param ManufacturerRepository $manufacturers
     */
    public function __construct(ManufacturerRepository $manufacturers)
    {
        parent::__construct();
        $this->manufacturers = $manufacturers;
        $this->authorizeResource(Manufacturer::class, 'manufacturer');
    }

    /**
     * Display a listing of manufacturers.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $statistics = \json_decode($this->statistics()->content());

        return view('manufacturers.index', ['statistics' => $statistics]);
    }

    /**
     * Show the form for creating a new manufacturer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manufacturers.create', ['countries' => app(CountryRepository::class)->all()]);
    }

    /**
     * Store a newly created manufacturer in storage.
     *
     * @param ManufacturerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ManufacturerRequest $request)
    {
        $this->manufacturers->create($request);

        return redirect('manufacturers')->with('success', __('manufacturers.flash_manufacturer_added'));
    }

    /**
     * Show the form for editing the specified manufacturer.
     *
     * @param string $id the id of the manufacturer
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return view('manufacturers.edit', [
            'manufacturer' => $this->manufacturers->find($id),
            'countries' => app(CountryRepository::class)->all()
        ]);
    }

    /**
     * Update the specified manufacturer in storage.
     *
     * @param ManufacturerRequest $request
     * @param string $id the id of the manufacturer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ManufacturerRequest $request)
    {
        // Force checkbox values as the unchecked fields are not included in the HTTP request.
        $request['equipment_supplier'] = $request->has('equipment_supplier') ? 1 : 0 ?? 0;
        $request['filament_supplier'] = $request->has('filament_supplier') ? 1 : 0 ?? 0;

        if ($this->manufacturers->update($id, $request)) {
            return redirect('manufacturers')->with('success', __('manufacturers.flash_manufacturer_updated'));
        }
    }

    /**
     * Get some basic statistics about the Manufacturers storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function statistics()
    {
        $manufacturers = Manufacturer::all();

        $stats['count'] = $manufacturers->count() ?? 0;

        return response()->json($stats, 200);
    }
}

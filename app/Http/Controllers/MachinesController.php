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

use App\Machine;
use App\Product;
use Illuminate\Http\Request;

class MachinesController extends Controller
{

    /**
     * MachinesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Machine::class, 'machine');
    }

    /**
     * Display a listing of machines.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $statistics = \json_decode($this->statistics()->content());

        return view('machines.index', ['statistics' => $statistics]);
    }

    public function statistics()
    {
        $machines = Machine::mine();

        $stats['count'] = $machines->count() ?? 0;
        $stats['value'] = (int)$machines->sum('acquisition_cost');

        return response()->json($stats, 200);
    }

    /**
     * Show the form for creating a new machine.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('machines.create')->with('models', $this->getProductModelList());
    }

    protected function getProductModelList(): array
    {
        $pm = Product::with('manufacturer:id,name')->where('class', 'machine')->get()->sortBy('name');
        $groups = [];
        foreach ($pm as $model) {
            $groups[$model->manufacturer->name][$model->id] = $model->name;
        }
        \ksort($groups);

        return $groups;
    }

    /**
     * Store a newly created machine in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:128'
        ]);
        $requestData = $request->all();

        // Merge with the current user ID
        $requestData = \array_merge($requestData, ['user_id' => auth()->user()->id]);

        Machine::create($requestData);

        return redirect('machines')->with('flash_message', 'Machine added!');
    }

    /**
     * Show the form for editing the specified machine.
     *
     * @param  Machine $machine
     *
     * @return \Illuminate\View\View
     */
    public function edit(Machine $machine)
    {
        $machine::with('model')->get();

        return view('machines.edit')->with('machine', $machine)->with('models', $this->getProductModelList());
    }

    public function show(Machine $machine)
    {
        echo $machine;
    }

    /**
     * Update the specified machine in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  Machine $machine
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Machine $machine)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:128',
            'operating_hours' => 'required'
        ]);
        $requestData = $request->all();

        $machine->update($requestData);

        return redirect('machines')->with('flash_message', 'Machine updated!');
    }

    /**
     * Remove the specified machine from storage.
     *
     * @param  Machine $machine
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect('machines')->with('flash_message', 'Machine deleted!');
    }
}

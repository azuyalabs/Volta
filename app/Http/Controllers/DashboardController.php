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
use Illuminate\View\View;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $lang = auth()->user()->profile->language ?? 'en-US';

        $machines = Machine::mypaired()->get();
        $refs = $machines->pluck('reference_id')->all();

        return view('dashboard')->with(
            [
                'lang' => $lang,
                'machines' => $refs,
            ]
        );
    }
}

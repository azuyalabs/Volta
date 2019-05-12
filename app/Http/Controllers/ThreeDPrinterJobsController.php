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

use Illuminate\Http\Request;

/**
 * Controller handling the management of 3D Printer Jobs
 *
 * @package App\Http\Controllers
 */
class ThreeDPrinterJobsController extends Controller
{
    /**
     * ThreeDPrinterJobsController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the authenticated user's 3D Printer Jobs.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('machinejobs.3dprinter.index');
    }
}
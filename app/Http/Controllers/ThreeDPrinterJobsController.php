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
use Illuminate\View\View;

/**
 * Controller handling the management of 3D Printer Jobs
 *
 * @package App\Http\Controllers
 */
class ThreeDPrinterJobsController extends Controller
{
    /**
     * Display a listing of the authenticated user's 3D Printer Jobs.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('machinejobs.3dprinter.index');
    }
}

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
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{

    /**
     * Display a listing of projects.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $projects = collect(Storage::disk('gcode')->files())->filter(static function ($value, $key) {
            $pathParts = \pathinfo($value);
            return $pathParts['extension'] === 'gcode';
        })->reject(static function ($value, $key) {
            return \substr($value, 0, 2) === "._";
        });

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Display the specified project.
     *
     * @param  string $project
     *
     * @return \Illuminate\View\View
     */
    public function show(string $project)
    {
        return view('projects.show', ['filename' => $project]);
    }
}

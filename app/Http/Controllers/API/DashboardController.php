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

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class DashboardController extends Controller
{

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function update(string $component)
    {
        try {
            $command = 'dashboard:' . $component;

            $exitCode = Artisan::call($command);
            if ($exitCode === 0) {
                return response()->json([
                    'status' => 'ok',
                    'message' => \sprintf('Command `%s` executed successfully.', $command)], 200);
            }
        } catch (CommandNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()], 404);
        }
    }
}

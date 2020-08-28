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

use App\Manufacturer;
use App\Repositories\CountryRepository;

class MetaDataController extends Controller
{
    public function countries()
    {
        $list = app(CountryRepository::class)->all();

        return response()->json($list, 200);
    }

    public function manufacturers()
    {
        $list = Manufacturer::all()->sortBy('name')->pluck('name', 'slug');

        return response()->json($list, 200);
    }
}

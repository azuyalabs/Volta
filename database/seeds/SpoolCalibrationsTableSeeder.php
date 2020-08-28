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

use App\SpoolCalibration;
use Illuminate\Database\Seeder;

/**
 * Class for seeding the spools calibrations table.
 */
class SpoolCalibrationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Spool Calibrations for demo users
        factory(SpoolCalibration::class, 25)->create();
    }
}

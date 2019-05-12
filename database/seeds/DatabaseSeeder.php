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

use Illuminate\Database\Seeder;

/**
 * Class for seeding the database
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ManufacturerTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            MachinesTableSeeder::class,
            //FilamentSpoolsTableSeeder::class,
            //SpoolCalibrationsTableSeeder::class,
        ]);
    }
}

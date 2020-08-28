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

use App\Http\Requests\ManufacturerRequest;
use App\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

/**
 * Class for seeding the Manufacturers table.
 */
class ManufacturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('/data/manufacturers.json'));
        $data = json_decode($json, true);

        $rules = (new ManufacturerRequest())->rules();

        $stats = [];

        $stats['new']     = 0;
        $stats['skipped'] = 0;
        $stats['failed']  = 0;

        foreach ($data as $obj) {
            $obj['system'] = true;

            $validator = Validator::make($obj, $rules);
            if ($validator->fails()) {
                ++$stats['failed'];
                $this->command->info(sprintf('Failed importing `%s`: %s', $obj['name'], $validator->getMessageBag()->first()));
                continue;
            }

            $model = Manufacturer::firstOrCreate($validator->validated());
            if ($model->wasRecentlyCreated) {
                ++$stats['new'];
            } else {
                ++$stats['skipped'];
            }
        }
        $this->command->info(sprintf('Imported %d manufacturer records (%d skipped, %d failed).', $stats['new'], $stats['skipped'], $stats['failed']));
    }
}

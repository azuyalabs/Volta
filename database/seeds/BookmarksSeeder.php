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

use App\Bookmark;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;

/**
 * Class for seeding the bookmarks table
 */
class BookmarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Since the Bookmark factory generates records randomly, duplicate entries may occur.
        // There is no particular check for this, rather that these are simply ignored.
        $bookmarks = factory(Bookmark::class, 25)->create();
        ;
        foreach ($bookmarks as $bookmark) {
            try {
                $bookmark->save();
            } catch (QueryException $e) {
            }
        }
    }
}

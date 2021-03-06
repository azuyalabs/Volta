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

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class for setting existing users as being verified to avoid new verification.
 */
class ExistingUsersVerifiedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email_verified_at', null)
            ->update(['email_verified_at' => Carbon::now()])
        ;
    }
}

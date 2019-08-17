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

use App\User;
use App\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            ManufacturersTableSeeder::class,
            ProductsTableSeeder::class,
        ]);

        $this->createDefaultUser();

        // Seed fake data for development
        if (app()->isLocal()) {
            $this->call([
                UsersTableSeeder::class,
                MachinesTableSeeder::class,
                FilamentSpoolsTableSeeder::class,
            ]);
        }
    }

    private function createDefaultUser(): void
    {
        $admin = User::create([
            'name'           => 'Alessandro Volta',
            'email'          => 'alessandro@volta.prof',
            'password'       => bcrypt('volta'),
            'remember_token' => Str::random(10),
            'api_token'      => Str::random(32),
        ]);

        $preferences['dashboard']['clock']['type']                = 'analog';
        $preferences['dashboard']['weather']['system_of_measure'] = 'metric';

        $profile = new UserProfile();
        $profile->fill([
            'currency'    => 'USD',
            'language'    => 'en-US',
            'country'     => 'IT',
            'city'        => 'Como',
            'preferences' => json_encode($preferences),
        ]);

        $admin->profile()->save($profile);

        $adminRoleName = 'admin';
        Role::create(['name' => $adminRoleName]);

        $admin->assignRole($adminRoleName);
    }
}

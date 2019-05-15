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
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Class for creating the initial roles and permissions
 */
class PermissionsRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Initialize permissions/roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'experimental']);

        // Assign roles to user '1' (SuperAdmin)
        $user = User::find(1);
        $user->assignRole(['admin', 'experimental']);
    }
}

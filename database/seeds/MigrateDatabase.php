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

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class for migrating data from a SQLite database to MySQL.
 *
 * WARNING: Use this class only ONCE in production!
 */
class MigrateDatabase extends Seeder
{
    protected const SOURCE_DATABASE = 'sqlite';
    /**
     * Connection handle to the source database.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $source_database;

    /**
     * Constructor.
     *
     * Initializes the source database
     */
    public function __construct()
    {
        $this->source_database = DB::connection(self::SOURCE_DATABASE);

        if (self::SOURCE_DATABASE === env('DB_CONNECTION')) {
            exit('ERROR: The source and target can not be the same. Please check your configuration (.env file)');
        }
    }

    /**
     * Run the database seeds.
     *
     * Note: telescope_* tables are not copied as this data is only used in development mode
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->seedTable('users');
        $this->seedTable('user_profile');
        $this->seedTable('password_resets');
        $this->seedTable('permissions');
        $this->seedTable('roles');
        $this->seedTable('role_has_permissions');
        $this->seedTable('model_has_permissions');
        $this->seedTable('model_has_roles');
        $this->seedTable('manufacturers');
        $this->seedTable('products');
        $this->seedTable('filament_spools');
        $this->seedTable('machines');
        $this->seedTable('machine_jobs');
        $this->seedTable('statuses');
        $this->seedTable('oauth_access_tokens');
        $this->seedTable('oauth_auth_codes');
        $this->seedTable('oauth_clients');
        $this->seedTable('oauth_personal_access_clients');
        $this->seedTable('oauth_refresh_tokens');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Seeds (copies) the data from the defined source database to the current database.
     * The current database is the one configured in the .env file.
     *
     * @param string $table_name name of the table
     */
    protected function seedTable(string $table_name): void
    {
        DB::table($table_name)->truncate(); // Empty table before copy

        // Get table data from production
        foreach ($this->source_database->table($table_name)->get() as $data) {
            // Save data to default db connection
            DB::table($table_name)->insert((array) $data);
        }
    }
}

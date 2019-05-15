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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration class for creating the manufacturers table.
 */
class CreateManufacturersTable extends Migration
{
    /**
     * Name of the database table
     */
    private const TABLE_NAME = 'manufacturers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            Schema::create(self::TABLE_NAME, function (Blueprint $table) {
                $table->increments('id');

                $table->string('name')->unique()->collation('utf8_bin');
                $table->string('slug')->nullable();
                $table->char('country', 2)->nullable();
                $table->string('website')->nullable();
                $table->boolean('filament_supplier')->default(false);
                $table->boolean('equipment_supplier')->default(false);

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}

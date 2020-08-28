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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class for creating the filament spools table.
 */
class CreateSpoolsTable extends Migration
{
    /**
     * Name of the database table.
     */
    private const TABLE_NAME = 'filament_spools';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            Schema::create(self::TABLE_NAME, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('manufacturer_id')->unsigned();

                $table->string('name')->nullable();
                $table->string('material');
                $table->mediumInteger('purchase_price')->default(0);
                $table->smallInteger('weight')->default(0);
                $table->decimal('diameter')->default(0);
                $table->decimal('density')->default(0);
                $table->float('usage')->default(0);
                $table->string('color')->nullable();
                $table->string('color_value')->nullable();

                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}

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
 * Migration class for creating the machines table.
 */
class CreateMachinesTable extends Migration
{
    /**
     * Name of the database table
     */
    private const TABLE_NAME = 'machines';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            Schema::create(self::TABLE_NAME, static function (Blueprint $table) {
                $table->increments('id');

                $table->string('name');
                $table->string('slug');
                $table->mediumInteger('acquisition_cost')->default(0);
                $table->mediumInteger('residual_value')->nullable()->default(0);
                $table->mediumInteger('maintenance_cost')->nullable()->default(0);
                $table->tinyInteger('lifespan')->default(1);
                $table->smallInteger('operating_hours')->default(1);
                $table->smallInteger('energy_consumption')->default(0);

                // Foreign keys / reference fields
                $table->string('reference_id', 100)->nullable();

                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

                $table->integer('model_id')->unsigned()->nullable();
                $table->foreign('model_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

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

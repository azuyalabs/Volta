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
 * Migration to increase the length of the reference ID field.
 * Some generated ID's are larger than the current 60 characters.
 */
class IncreaseReferenceFieldSize extends Migration
{
    /**
     * Name of the database table
     */
    private const TABLE_NAME = 'machines';

    /**
     * Name of the table column
     */
    private const COLUMN_NAME = 'reference_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->string(self::COLUMN_NAME, 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->string(self::COLUMN_NAME, 60)->change();
        });
    }
}

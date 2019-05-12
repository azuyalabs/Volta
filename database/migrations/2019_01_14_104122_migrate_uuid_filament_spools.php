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

use Illuminate\Support\Facades\DB;
use Spatie\BinaryUuid\HasBinaryUuid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration that will convert the Spools table to use an UUID as the primary key.
 * Additionally, the slug field is removed and a field indicating the current filament spools usage.
 */
class MigrateUuidFilamentSpools extends Migration
{
    /**
     * Name of the temporary database table
     */
    private const TABLE_NAME_CURRENT = 'spools';

    /**
     * Name of the database table
     */
    private const TABLE_NAME_NEW = 'filament_spools';

    /**
     * Name of the table column
     */
    private const COLUMN_NAME_PRIMARY_KEY = 'uuid';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME_NEW, function (Blueprint $table) {
            $table->uuid(self::COLUMN_NAME_PRIMARY_KEY)->primary()->nullable();
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

        // Transfer records
        $spools = DB::table(self::TABLE_NAME_CURRENT)->get();
        $spools->each(function ($item) {
            DB::table(self::TABLE_NAME_NEW)->insert(
                [
                    self::COLUMN_NAME_PRIMARY_KEY => HasBinaryUuid::encodeUuid(HasBinaryUuid::generateUuid()),
                    'user_id' => $item->user_id,
                    'manufacturer_id' => $item->manufacturer_id,
                    'name' => $item->name,
                    'material' => $item->material,
                    'purchase_price' => $item->purchase_price,
                    'weight' => $item->weight,
                    'diameter' => $item->diameter,
                    'density' => $item->density,
                    'color' => $item->color,
                    'color_value' => \strtolower($item->colorcode),
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]
            );
        });

        // Drop old table
        Schema::dropIfExists(self::TABLE_NAME_CURRENT);

        Schema::table(self::TABLE_NAME_NEW, function (Blueprint $table) {
            $table->unique(self::COLUMN_NAME_PRIMARY_KEY);
        });
    }
}

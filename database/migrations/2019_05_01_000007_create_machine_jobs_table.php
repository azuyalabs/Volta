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

use App\MachineJobType;
use App\MachineJobStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration class for creating the Machine Jobs table.
 */
class CreateMachineJobsTable extends Migration
{
    /**
     * Name of the database table
     */
    private const TABLE_NAME = 'machine_jobs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            Schema::create(self::TABLE_NAME, function (Blueprint $table) {
                $table->uuid('uuid')->primary()->nullable();
                $table->char('job_id', 16);

                $table->integer('user_id')->unsigned();
                $table->integer('machine_id')->unsigned();
                $table->string('name');
                $table->enum('status', [MachineJobStatus::SUCCESS, MachineJobStatus::FAILED, MachineJobStatus::IN_PROGRESS]);
                $table->unsignedMediumInteger('duration')->default(0);
                $table->enum('type', [MachineJobType::THREE_D_PRINTER, MachineJobType::LASER, MachineJobType::ROUTER]);
                $table->longText('details')->nullable();

                // Relationships
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade')->onUpdate('cascade');

                // Indexes
                $table->index('type');

                // Timestamps
                $table->timestamps();
                $table->softDeletes();
            });
        }

        $this->addStartedAtColumn();
    }

    /**
     * Create the 'started_at' column.
     *
     * Needs to be done with a raw DB statement as the default datetime method
     * isn't allowing to set the correct data type needed (timestamp).
     */
    protected function addStartedAtColumn()
    {
        $startedAtColumnName = 'started_at';
        $startedAtIndexName  = self::TABLE_NAME . '_job_unique';

        DB::statement(\sprintf('ALTER TABLE %s ADD COLUMN %s timestamp NULL DEFAULT NULL;', self::TABLE_NAME, $startedAtColumnName));
        DB::statement(\sprintf('CREATE UNIQUE INDEX %s on %s(%s, %s, %s);', $startedAtIndexName, self::TABLE_NAME, 'job_id', 'name', $startedAtColumnName));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}

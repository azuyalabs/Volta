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

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class that handles pruning the Volta Database
 *
 * @package App\Console
 */
class OptimizeCommand extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'volta:optimize';

    /**
     * @var string The console command description
     */
    protected $description = 'Optimize the Volta Database';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        $this->pruneStatuses();
        $this->call('telescope:prune');
        $this->vacuumDatabase();
    }

    /**
     * Transaction safe command to prune stale model statuses.
     */
    private function pruneStatuses()
    {
        DB::beginTransaction();
        try {
            DB::table('statuses')->whereRaw('id not in (select max(id) from statuses group by model_id)')->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
        DB::commit();

        $this->info('Old model statuses pruned.');
    }

    private function vacuumDatabase()
    {
        DB::statement('VACUUM;');
        
        $this->info('Database vacuumed.');
    }
}

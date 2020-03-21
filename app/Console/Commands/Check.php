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

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\System\UpdateManager;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volta:check-for-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if a new update is available.';

    /**
     * @var UpdateManager
     */
    private $updateManager;

    public function __construct(UpdateManager $updateManager)
    {
        parent::__construct();
        $this->updateManager = $updateManager;
    }

    /**
     * Execute the command.
     */
    public function handle(): void
    {
    }
}

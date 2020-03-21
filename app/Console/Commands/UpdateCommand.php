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

use App\Volta;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volta:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Volta installation';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->onLatestRelease()) {
            $this->info(
                sprintf(
                    'You are already running the latest release of %s.',
                    config('app.name')
                )
            );

            return;
        }

//        $downloadPath = (new Updating\DownloadRelease($this))->download(
//            $release = $this->latestSparkRelease($this->targetMajorVersion)
//        );

//        $updaters = collect([
//            Updating\UpdateViews::class,
//            Updating\UpdateInstallation::class,
//            Updating\RemoveDownloadPath::class,
//        ]);

//        $updaters->each(function ($updater) use ($downloadPath) {
//            (new $updater($this, $downloadPath))->update();
//        });

        $release = '0.0.5';

        $this->info(
            sprintf(
                'You are now running on %s v%s. Enjoy!.',
                config('app.name'),
                $release
            )
        );
    }

    /**
     * Determine if the application is already on the latest version.
     *
     * @return bool
     */
    protected function onLatestRelease(): bool
    {
        return version_compare(
            Volta::VERSION,
            //$this->latestRelease(),
            '0.0.4',
            '>='
        );
    }
}

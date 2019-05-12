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

namespace App\Listeners;

use App\Machine;
use App\MachineJob;
use App\MachineJobType;
use App\MachineJobStatus;
use Illuminate\Support\Facades\DB;
use App\Events\PrinterMonitor\PrinterStatusFetched;

/**
 * Class PrintStateReceived
 *
 * @package App\Listeners
 */
class PrintStateReceived
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param PrinterStatusFetched $event
     * @return void
     */
    public function handle(PrinterStatusFetched $event)
    {
        $machine = Machine::firstOrCreate(
            ['reference_id' => $event->status['id']],
            ['name' => $event->status['name'],
                'user_id' => auth()->user()->id,
            ]
        );

        if (null !== $machine->reference_id) {

            // Update the operational state of this machine
            if ($machine->status !== $event->status['state']) {
                $machine->setStatus($event->status['state']);
            }

            // Create a new machine job entry
            if (isset($event->status['printjob'])) {
                DB::beginTransaction();
                try {
                    $job = MachineJob::firstOrCreate(
                        [
                            'job_id' => \hash('fnv1a64', $event->status['id'] . $event->status['printjob']['filename'] . $event->status['printjob']['started_at'])
                        ],
                        [
                            'user_id' => auth()->user()->id,
                            'name' => $event->status['printjob']['filename'],
                            'started_at' => $event->status['printjob']['started_at'],
                            'type' => MachineJobType::THREE_D_PRINTER,
                            'machine_id' => $machine->id,
                            'status' => MachineJobStatus::IN_PROGRESS,
                        ]
                    );

                    $job->status = $event->status['printjob']['status'];
                    $job->duration = (int)$event->status['printjob']['time_elapsed'];

                    // Save details
                    $details = \json_decode($job->details, true);
                    if (isset($event->status['printjob']['filament_length']) && $event->status['printjob']['filament_length'] > 0) {
                        $details['filament_length'] = $event->status['printjob']['filament_length'];
                    }

                    if (isset($event->status['heatbed_temperature']['target']) && $event->status['heatbed_temperature']['target'] > 0) {
                        $details['heatbed_target_temperature'] = $event->status['heatbed_temperature']['target'];
                    }

                    if (isset($event->status['extruder_temperature']['target']) && $event->status['extruder_temperature']['target'] > 0) {
                        $details['extruder_temperature'] = $event->status['extruder_temperature']['target'];
                    }
                    $job->details = \json_encode($details);

                    $job->save();
                } catch (\Exception $e) {
                    DB::rollback();
                }
                DB::commit();
            }
        }
    }
}

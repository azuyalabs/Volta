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

namespace App\Http\Controllers\API;

use App\MachineJobType;

class ThreeDPrinterJobsController extends MachineJobController
{
    /**
     * @inheritdoc
     */
    protected function machineType()
    {
        return MachineJobType::THREE_D_PRINTER;
    }
}

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

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrintJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'printjobs',
            'id'   => (string)$this->gcode_filename,

            'attributes' => [
                'name'                  => $this->gcode_filename,
                'filamentInLength'      => $this->printUsedFilamentLength,
                'filamentDiameter'      => $this->filamentDiameter,
                'filamentDensity'       => $this->filamentDensity,
                'estimatedPrintingTime' => $this->estimatedPrintingTime,
                'slicer'                => $this->slicer,
                'bedTemperature'        => $this->bedTemperature,
                'hotendTemperature'     => $this->hotendTemperature,
                'layerHeight'           => $this->layerHeight,
                'fillDensity'           => $this->fillDensity,
                'perimeterSpeed'        => $this->perimeterSpeed,
            ],
            'links' => [
                'self' => route('printjobs.show', ['printjob' => $this->gcode_filename]),
            ],
        ];
    }
}

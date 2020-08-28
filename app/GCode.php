<?php

declare(strict_types=1);
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

namespace App;

use RuntimeException;
use SplFileObject;

class GCode extends SplFileObject
{
    const KISSSLICER = 'KISSlicer';
    const SLIC3RPE   = 'Slic3rPE';
    const CURA       = 'Cura';
    const SIMPLIFY3D = 'Simplify3D';
    public $printUsedFilamentLength;
    public $printUsedFilamentVolume;
    public $printUsedFilamentWeight;
    public $estimatedPrintingTime;
    public $filamentDensity;
    public $filamentDiameter;
    public $filamentCost;
    public $printCost;
    public $bedTemperature;
    public $hotendTemperature;
    public $nozzleDiameter;
    public $layerHeight;
    public $fillDensity;
    public $perimeterSpeed;
    public $printerModel;
    public $gcode_filename;
    public $slicer;

    public function __construct(string $filename)
    {
        if (!is_readable($filename)) {
            throw new RuntimeException('File not readable.');
        }

        try {
            parent::__construct($filename);
            $this->gcode_filename = basename($filename, '.gcode');

            while (!$this->eof()) {
                $line = $this->fgets();

                // Detect which slicer was used
                $this->detectSlicer($line);

                // KISSlicer specific parameters
                if (self::KISSSLICER === $this->slicer) {
                    if (preg_match('/^; fiber_dia_mm = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->filamentDiameter = (float) $match[1];
                    }

                    if (preg_match('/^; extrusion_width_mm = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->nozzleDiameter = (float) $match[1];
                    }

                    if (preg_match('/^; layer_thickness_mm = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->layerHeight = (float) $match[1];
                    }

                    if (preg_match('/^; infill_style = (\\d+)/i', $line, $match)) {
                        $this->fillDensity = (float) 100 / $match[1];
                    }

                    if (preg_match('/^; Estimated Build Time:\\s*(\\d*)\\.(\\d{2})\\sminutes/i', $line, $match)) {
                        $this->estimatedPrintingTime = (int) $match[1] * 60 + floor(($match[2] / 100) * 60);
                    }

                    if (preg_match('/^; hi_speed_perim_mm_per_s =\\s*(\\d+)?/i', $line, $match)) {
                        $this->perimeterSpeed = (float) $match[1];
                    }

                    if (preg_match('/^;\\s*Ext 1 =\\s*(\\d+\\.?\\d+)/', $line, $match)) {
                        $this->printUsedFilamentLength = (float) $match[1];
                    }
                } elseif (self::SLIC3RPE === $this->slicer) {
                    if (preg_match('/^; filament used = (\\d+\\.\\d+)mm/i', $line, $match)) {
                        $this->printUsedFilamentLength = (float) $match[1];
                    }

                    if (preg_match('/((\\d+)h)?\\s?((\\d+)m)?\\s?(\\d+)s/i', $line, $match)) {
                        $this->estimatedPrintingTime = (int) $match[2] * 3600 + (int) $match[4] * 60 + (int) $match[5];
                    }

                    if (preg_match('/^; filament_cost = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->filamentCost = (float) $match[1];
                    }

                    if (preg_match('/^; filament_density = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->filamentDensity = (float) $match[1];
                    }

                    if (preg_match('/^; filament_diameter = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->filamentDiameter = (float) $match[1];
                    }

                    if (preg_match('/^; nozzle_diameter = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->nozzleDiameter = (float) $match[1];
                    }

                    if (preg_match('/^; bed_temperature = (\\d+)/i', $line, $match)) {
                        $this->bedTemperature = (int) $match[1];
                    }

                    if (preg_match('/^; fill_density = (\\d+)\\%?/i', $line, $match)) {
                        $this->fillDensity = (int) $match[1];
                    }

                    if (preg_match('/^; perimeter_speed = (\\d+)?/i', $line, $match)) {
                        $this->perimeterSpeed = (float) $match[1];
                    }

                    if (preg_match('/^; printer_model = (\\S+)?/i', $line, $match)) {
                        $this->printerModel = (string) $match[1];
                    }

                    if (preg_match('/^; layer_height = (\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->layerHeight = (float) $match[1];
                    }
                } elseif (self::CURA === $this->slicer) {
                    if (preg_match('/^;Layer height: (\\d+\\.?\\d+)$/', $line, $match)) {
                        $this->layerHeight = (float) $match[1];
                    }

                    if (preg_match('/^;TIME:(\\d+)$/', $line, $match)) {
                        $this->estimatedPrintingTime = (int) $match[1];
                    }

                    if (preg_match('/^;Filament used:\\s?(\\d+\\.?\\d+)m$/', $line, $match)) {
                        $this->printUsedFilamentLength = (float) $match[1] * 1000;
                    }
                } elseif (self::SIMPLIFY3D === $this->slicer) {
                    if (preg_match('/^;   Filament length: (\\d+\\.\\d+) mm/i', $line, $match)) {
                        $this->printUsedFilamentLength = (float) $match[1];
                    }

                    if (preg_match('/^;   filamentDensities,(\\S+)/i', $line, $match)) {
                        $densities             = explode('|', $match[1]);
                        $this->filamentDensity = (float) $densities[0];
                    }

                    if (preg_match('/^;   filamentDiameters,(\\S+)/i', $line, $match)) {
                        $diameters              = explode('|', $match[1]);
                        $this->filamentDiameter = (float) $diameters[0];
                    }

                    if (preg_match('/;   Build time: (\\d+) hours (\\d{1,2}) minutes/i', $line, $match)) {
                        $this->estimatedPrintingTime = (int) $match[1] * 3600 + (int) $match[2] * 60;
                    }

                    if (preg_match('/^;   infillPercentage,(\\d{1,3})/i', $line, $match)) {
                        $this->fillDensity = (int) $match[1];
                    }

                    if (preg_match('/^;   layerHeight,(\\d+\\.?\\d+)/i', $line, $match)) {
                        $this->layerHeight = (float) $match[1];
                    }

                    if (preg_match('/^;   defaultSpeed,(\\d{1,5})/i', $line, $match)) {
                        $this->perimeterSpeed = (float) $match[1] / 60;
                    }
                }

                if (preg_match('/^M140 S(\\d{2,3})?/i', $line, $match) && null === $this->bedTemperature) {
                    if (isset($match[1])) {
                        $this->bedTemperature = (int) $match[1];
                    }
                }

                if (preg_match('/^M104 S(\\d+)?/i', $line, $match) && null === $this->hotendTemperature) {
                    if (isset($match[1])) {
                        $this->hotendTemperature = (int) $match[1];
                    }
                }

                $filamentArea                  = (M_PI * $this->filamentDiameter ** 2)            / 4;
                $this->printUsedFilamentVolume = ($filamentArea * $this->printUsedFilamentLength) / 1000;
                $this->printUsedFilamentWeight = $this->printUsedFilamentVolume * $this->filamentDensity;

                $this->printCost = $this->printUsedFilamentWeight / 1000 * $this->filamentCost;
            }
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }

    private function detectSlicer($gcode)
    {
        // Only trying to detect if not detected before
        if (null !== $this->slicer) {
            return;
        }

        // Only check comments
        if (0 !== strpos($gcode, ';')) {
            return;
        }

        if (false !== strpos($gcode, 'Slic3r Prusa Edition')) {
            $this->slicer = self::SLIC3RPE;
        } elseif (false !== strpos($gcode, 'KISSlicer')) {
            $this->slicer = self::KISSSLICER;
        } elseif (false !== strpos($gcode, 'Slicer')) {
            $this->slicer = 'Slicer';
        } elseif (false !== strpos($gcode, 'FLAVOR')) {
            $this->slicer = self::CURA;
        } elseif (false !== strpos($gcode, 'Simplify3D')) {
            $this->slicer = self::SIMPLIFY3D;
        }
    }
}

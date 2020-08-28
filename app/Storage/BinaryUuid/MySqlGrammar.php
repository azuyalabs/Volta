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

namespace App\Storage\BinaryUuid;

use Illuminate\Database\Schema\Grammars\MySqlGrammar as IlluminateMySqlGrammar;
use Illuminate\Support\Fluent;

class MySqlGrammar extends IlluminateMySqlGrammar
{
    protected function typeUuid(Fluent $column)
    {
        return 'binary(16)';
    }
}

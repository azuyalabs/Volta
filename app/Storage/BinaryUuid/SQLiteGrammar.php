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

namespace App\Storage\BinaryUuid;

use Illuminate\Database\Schema\Grammars\SQLiteGrammar as IlluminateSQLiteGrammar;
use Illuminate\Support\Fluent;

class SQLiteGrammar extends IlluminateSQLiteGrammar
{
    protected function typeUuid(Fluent $column)
    {
        return 'blob(256)';
    }
}

<?php

namespace App\Core\Logger;

use RuntimeException;

class LogToDatabase implements Logger
{

    public function info($data): bool
    {
        //
        return false;
    }

    public function error($data): bool
    {
        //
        return false;
    }

}
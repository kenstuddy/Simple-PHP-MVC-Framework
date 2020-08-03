<?php

namespace App\Core\Logger;
interface Logger
{

    public function info($data): bool;

    public function error($data): bool;

}
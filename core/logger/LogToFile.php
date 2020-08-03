<?php

namespace App\Core\Logger;

use RuntimeException;

class LogToFile implements Logger
{

    public function info($data): bool
    {
        return $this->log($data, "info.log");
    }

    public function error($data): bool
    {
        return $this->log($data, "error.log");
    }

    private function log($data, $filename = "log.log"): bool
    {
        if (!file_exists("../logs/") && (!mkdir("../logs/", 0777, true) && !is_dir($filename))) {
            throw new RuntimeException(sprintf('Folder "%s" was not created', $filename));
        }
        return file_put_contents("../logs/" . $filename, date("Y-m-d h:i:sa") . " " . $data . "\n", FILE_APPEND);
    }
}
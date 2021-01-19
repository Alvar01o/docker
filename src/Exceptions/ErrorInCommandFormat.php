<?php

namespace Spatie\Docker\Exceptions;

use Exception;
use Spatie\Docker\DockerContainer;
use Symfony\Component\Process\Process;

class ErrorInCommandFormat extends Exception
{
    public static function processFailed()
    {
        return new static("Malformed Docker command sintax");
    }
}

<?php

namespace Spatie\Docker\Exceptions;

use Exception;
use Symfony\Component\Process\Process;

class MovingError extends Exception
{
    public static function processFailed(DockerContainer $container, Process $process)
    {
        return new static("Could not move into {$container->directory}`. Process output: `{$process->getErrorOutput()}`");
    }
}

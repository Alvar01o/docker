<?php

namespace Spatie\Docker\Exceptions;

use Exception;
use Spatie\Docker\DockerCompose\DockerCompose;
use Symfony\Component\Process\Process;

class CouldNotStartDockerCompose extends Exception
{
    public static function processFailed(DockerCompose $compose, Process $process)
    {
        return new static("Could not start docker-compose on {$compose->directory}`. Process output: `{$process->getErrorOutput()}`");
    }
}

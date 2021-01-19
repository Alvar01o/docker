<?php
namespace Spatie\DockerCompose;

use Symfony\Component\Process\Process;
use Spatie\Docker\Exceptions\ErrorInCommandFormat;
use Spatie\Docker\Exceptions\CouldNotStartDockerCompose;

class DockerCompose
{

    public string $directory;

    private Array $options;

    public function __construct(string $path) {
        $this->directory = $path;
    }

    public function getOptions(){
        return implode($this->options , ' ');
    }

    public function up()
    {
        if(in_array('down' , $this->options)){
            ErrorInCommandFormat::processFailed();
        } else {
            $this->options[] = 'up';
        }
    }

    public function down()
    {
        if(in_array('up' , $this->options)){
            ErrorInCommandFormat::processFailed();
        } else {
            $this->options[] = 'down';
        }
    }

    public function move()
    {
        $command = "cd ".$this->directory;
        $process = Process::fromShellCommandline($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw MovingError::processFailed($this, $process);
        }
    }

    public function start()
    {
        $this->move($this->directory);

        $command = $this->getStartCommand();

        $process = Process::fromShellCommandline($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw CouldNotStartDockerCompose::processFailed($this, $process);
        }
    }

    public function getStartCommand() : string
    {
        return "docker-compose ".$this->getOptions();
    }

}

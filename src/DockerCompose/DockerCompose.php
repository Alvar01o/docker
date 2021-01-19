<?php
namespace Spatie\Docker\DockerCompose;

use Symfony\Component\Process\Process;
use Spatie\Docker\Exceptions\ErrorInCommandFormat;
use Spatie\Docker\Exceptions\CouldNotStartDockerCompose;

class DockerCompose
{

    public string $directory;

    private Array $options;

    public int $timeOut;

    public function __construct(string $path) {
        $this->directory = $path;
        $this->options = [];
        $this->timeOut = 300;
    }

    public function getOptions(){
        return implode(' ', $this->options);
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

    public function move($process, $path)
    {
        return $process->setWorkingDirectory($path);
    }

    public function setTimeout(){

    }
    public function start()
    {
        $command = $this->getStartCommand();

        $process = Process::fromShellCommandline($command);

        $this->move($process , $this->directory);

        $process->setTimeout($this->timeOut);

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

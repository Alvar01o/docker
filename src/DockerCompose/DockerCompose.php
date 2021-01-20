<?php
namespace Spatie\Docker\DockerCompose;

use Symfony\Component\Process\Process;
use Spatie\Docker\Exceptions\ErrorInCommandFormat;
use Spatie\Docker\Exceptions\CouldNotStartDockerCompose;

class DockerCompose
{

    public string $directory;

    private array $options;

    public int $ttl = 0;

    public function __construct(string $path) {
        $this->directory = $path;
        $this->options = [];
        $this->options[] = '-d';
    }

    public function getOptions(){
        return implode(' ', array_reverse($this->options));
    }

    public function doNotDaemonize()
    {
        $this->options = array_filter($this->options, fn ($m) => $m != '-d');
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

    public function setTimeout($ttl){
        $this->ttl = $ttl;
    }


    public function startRealTime(){

        $command = $this->getStartCommand();

        $process = Process::fromShellCommandline($command);

        $this->move($process , $this->directory);

        $process->setTimeout($this->ttl);

        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });

    }
    public function start()
    {
        $command = $this->getStartCommand();

        $process = Process::fromShellCommandline($command);

        $this->move($process , $this->directory);

        $process->setTimeout($this->ttl);

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

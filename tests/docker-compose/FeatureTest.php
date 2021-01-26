<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spatie\Docker\DockerCompose\DockerCompose;
use Symfony\Component\Process\Process;

class FeatureTest extends TestCase
{

    public function testBasic(){
        $directory = './tests/docker-compose/docker-compose/';
        $dockerCompose = new DockerCompose($directory);
        //implement docker-compose docker-compose exec <containerName> <command>

        $process = new Process(['winpty', 'docker-compose' , 'exec' , 'commands' , 'ls ../']);

        $dockerCompose->move($process , $directory);


        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });

        $this->assertTrue(true);
    }

//    public function testDockerComposeUp(){
//        $directory = './tests/docker-compose/docker-compose/';
//        $dockerCompose = new DockerCompose($directory);
//        $dockerCompose->up();
//        $dockerCompose->start();
//        $this->assertTrue(true);
//    }
//
//    public function testDockerComposeDown(){
//        $directory = './tests/docker-compose/docker-compose/';
//        $dockerCompose = new DockerCompose($directory);
//        $dockerCompose->stop();
//        $dockerCompose->start();
//        $this->assertTrue(true);
//    }
//    public function testDockerComposeUpShellInjection(){
//        $directory = './tests/docker-compose/docker-compose/';
//        $dockerCompose = new DockerCompose($directory);
//        $dockerCompose->up();
//        $process = $dockerCompose->start();
//        $DockerCommand = new DockerCompose($directory);
//        $DockerCommand->command('commands', "ls ../");
//        $this->assertTrue(true);
//    }


//    public function testDockerComposeStopInjectedContainer(){
//        $imageName = './tests/docker-compose/docker-compose/';
//        $dockerCompose = new DockerCompose($imageName);
//        $dockerCompose->stop();
//        $dockerCompose->start();
//        $this->assertTrue(true);
//    }
}

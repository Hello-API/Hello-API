<?php

namespace App\Containers\Documentation\Tasks;

use App\Containers\Documentation\Contracts\ApiTypeInterface;
use App\Port\Task\Abstracts\Task;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class GenerateApiDocJsDocsTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GenerateApiDocJsDocsTask extends Task
{

    /**
     * @var  \Illuminate\Config\Repository
     */
    private $config;

    /**
     * GenerateApiDocJsDocsTask constructor.
     *
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param \App\Containers\Documentation\Contracts\ApiTypeInterface $type
     *
     * @return  mixed
     */
    public function run(ApiTypeInterface $type)
    {
        // the actual command that needs to be executed:
        $command = $this->config->get('apidoc.executable') . ' ' . $type->getCommand();

        // execute the command
        ($process = new Process($command))->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // echo the output
        echo $type->getType() . ': ' . $process->getOutput();

        // return the past to that generated documentation
        return $type->getUrl();
    }

}

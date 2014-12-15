<?php namespace Pasadinhas\Console\AFS\Commands\Permissions;

use Pasadinhas\Console\AFS\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListPermissionsCommand extends PermissionsCommand {

    public function configure()
    {
        $this->setName("permissions:list")
            ->addArgument("name");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $name = $input->getArgument("name");
        $this->assertFileExists($name);

        return $this->listPermissionsFor($name);
    }

    protected function listPermissionsFor($name)
    {
        $command = sprintf("fs listacl %s", $name);
        $success = $this->executeShellCommand($command, $output);

        if ( ! $success) return "die";

        print_r($output);

        return;
    }
} 
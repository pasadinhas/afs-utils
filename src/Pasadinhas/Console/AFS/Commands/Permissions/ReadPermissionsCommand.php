<?php namespace Pasadinhas\Console\AFS\Commands\Permissions;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReadPermissionsCommand extends PermissionsCommand {

    public function configure()
    {
        parent::configure();

        $this->setName("permissions:read");
        $this->setDescription("Add or remove read permissions to files.");
    }

    protected function handleRemovePermissionsFromFile(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument("name");

        $output->writeln("<comment>[INFO] Removing read permissions from file $name</comment>");

        $command = "fs sa $name r";
        $success = $this->executeShellCommand($output, $command);
        if ( ! $success) return;

        $command = "chmod -r $name";
        $success = $this->executeShellCommand($output, $command);
        if ( ! $success) return;

        $output->writeln("<info>[DONE] Operation complete!</info>");
    }

    protected function handleRemovePermissionsFromDirectory(InputInterface $input, OutputInterface $output)
    {
        // TODO: Implement handleRemovePermissionsFromDirectory() method.
    }

    protected function handleAddPermissionsFromFile(InputInterface $input, OutputInterface $output)
    {
        // TODO: Implement handleAddPermissionsFromFile() method.
    }

    protected function handleAddPermissionsFromDirectory(InputInterface $input, OutputInterface $output)
    {
        // TODO: Implement handleAddPermissionsFromDirectory() method.
    }

}
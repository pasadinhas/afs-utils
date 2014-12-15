<?php namespace Pasadinhas\Console\AFS\Commands\Permissions;

use Pasadinhas\Console\AFS\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ChangePermissionsCommand extends BaseCommand {

    const PERMISSIONS_ADD = 0;
    const PERMISSIONS_REMOVE = 1;
    const PERMISSIONS_INVALID = 2;

    public function configure()
    {
        $this->addArgument("name", InputArgument::REQUIRED, "The file/folder to add/remove permissions.");
        $this->addOption("remove", null, InputOption::VALUE_NONE, "Use this flag to remove permissions.");
        $this->addOption("add", null, InputOption::VALUE_NONE, "Use this flag to add permissions. [default]");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->actionIsInvalid($input)) {
            $output->writeln("<error>[Error] You can't use --add and --remove flags at once.</error>");

            return;
        }

        $name = $input->getArgument("name");

        if (!file_exists($name)) {
            $output->writeln("<error>[Error] $name not found.</error>");

            return;
        }

        $isFile = is_file($name);

        if ($this->actionIsRemove($input)) {
            if ($isFile)
                return $this->handleRemovePermissionsFromFile($input, $output);

            return $this->handleRemovePermissionsFromDirectory($input, $output);
        }

        if ($this->actionIsAdd($input)) {
            if ($isFile)
                return $this->handleAddPermissionsFromFile($input, $output);

            return $this->handleAddPermissionsFromDirectory($input, $output);
        }
    }

    protected function getActionType(InputInterface $input)
    {
        $add = $input->getOption("add");
        $remove = $input->getOption("remove");

        if ($add and $remove)
            return self::PERMISSIONS_INVALID;

        if ($remove)
            return self::PERMISSIONS_REMOVE;

        return self::PERMISSIONS_ADD;
    }

    protected function actionIsAdd(InputInterface $input)
    {
        return $this->getActionType($input) == self::PERMISSIONS_ADD;
    }

    protected function actionIsRemove(InputInterface $input)
    {
        return $this->getActionType($input) == self::PERMISSIONS_REMOVE;
    }

    protected function actionIsInvalid(InputInterface $input)
    {
        return $this->getActionType($input) == self::PERMISSIONS_INVALID;
    }

    abstract protected function handleRemovePermissionsFromFile(InputInterface $input, OutputInterface $output);
    abstract protected function handleRemovePermissionsFromDirectory(InputInterface $input, OutputInterface $output);
    abstract protected function handleAddPermissionsFromFile(InputInterface $input, OutputInterface $output);
    abstract protected function handleAddPermissionsFromDirectory(InputInterface $input, OutputInterface $output);
}
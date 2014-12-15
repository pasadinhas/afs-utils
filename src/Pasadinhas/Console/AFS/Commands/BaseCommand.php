<?php namespace Pasadinhas\Console\AFS\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command {

    /**
     * The input channel.
     *
     * @var InputInterface $input
     */
    protected $input = null;

    /**
     * The output channel.
     *
     * @var OutputInterface $output
     */
    protected $output = null;

    /**
     * Registers the input and output channels.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function registerInputOutputInterfaces(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->registerInputOutputInterfaces($input, $output);
    }

    /**
     * Runs a shell command.
     *
     * @param       $command
     * @param array $output
     *
     * @return bool
     */
    protected function executeShellCommand($command, array &$output)
    {
        // Ignore stdErr output
        $command = "($command) 2> /dev/null";

        exec($command, $output, $result);
        $success = ! $result;

        return $success;
    }

    protected function requireOutputInterface()
    {
        if (null === $this->output)
        {
            throw new \LogicException("No output interface registered.
                Did you use the registerInputOutputInterfaces method?");
        }
    }

    protected function requireInputInterface()
    {
        if (null === $this->input)
        {
            throw new \LogicException("No input interface registered.
                Did you use the registerInputOutputInterfaces method?");
        }
    }

    protected function requireInputOutputInterfaces()
    {
        $this->requireInputInterface();
        $this->requireOutputInterface();
    }

    protected function writeSuccessLn($message)
    {
        $this->requireOutputInterface();

        $message = sprintf("<comment>[ OK ] %s</comment>", $message);

        $this->output->writeln($message);
    }

    protected function writeErrorLn($message)
    {
        $this->requireOutputInterface();

        $message = sprintf("<error>[FAIL] %s</error>", $message);

        $this->output->writeln($message);
    }

    protected function writeInfoLn($message)
    {
        $this->requireOutputInterface();

        $message = sprintf("<info>[INFO] %s</info>", $message);

        $this->output->writeln($message);
    }

}
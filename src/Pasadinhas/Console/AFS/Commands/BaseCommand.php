<?php namespace Pasadinhas\Console\AFS\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command {

    /**
     * @param OutputInterface $output
     * @param                 $command
     * @param bool            $quiet
     *
     * @return bool
     */
    protected function executeShellCommand(OutputInterface $output, $command, $quiet = true)
    {
        $originalCommand = $command;

        if ($quiet) {
            $command = "($originalCommand) 2> /dev/null";
        }

        exec($command, $cmdOutput, $result);
        unset($cmdOutput);

        $success = ! $result;

        if ( ! $success) {
            $output->writeln("<error>[FAIL] \"$originalCommand\" failed! Aborting.</error>");

            return $success;
        }

        $output->writeln("<info>[ OK ] $originalCommand</info>");

        return $success;
    }
}
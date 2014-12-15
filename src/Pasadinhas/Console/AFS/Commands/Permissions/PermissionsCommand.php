<?php namespace Pasadinhas\Console\AFS\Commands\Permissions;

use Pasadinhas\Console\AFS\Commands\BaseCommand;
use Pasadinhas\Console\AFS\Exceptions\FileOrClassDoesNotExistException;

class PermissionsCommand extends BaseCommand {

    protected function assertFileExists($name)
    {
        if ( ! file_exists($name))
        {
            $message = sprintf("The file/directory %s does not exist.", $name);
            throw new FileOrClassDoesNotExistException($message);
        }
    }
} 
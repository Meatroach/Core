<?php

namespace OpenTribes\Core\Silex\Composer;

use Composer\Script\CommandEvent;
use OpenTribes\Core\Silex\Environment;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Static script handler that executes some post-script actions
 */
class ScriptHandler
{
    /**
     * Creates the dev and test environment during the composer install.
     * Creation will be skipped if the "--no-dev" option is provided (usually used when deploying to production)
     *
     * @param CommandEvent $event
     */
    public static function createDevAndTestEnvironment(CommandEvent $event)
    {
        if ($event->isDevMode()) {
            $devCmds = [
                sprintf(
                    '%s cli/config.php create %s --db_name=ot_dev --db_user=dev --db_pass=dev',
                    self::getPhpExecutable(),
                    Environment::DEVELOP
                ),
                sprintf(
                    '%s cli/migration.php migrations:migrate 1 %s --no-interaction',
                    self::getPhpExecutable(),
                    Environment::DEVELOP
                )
            ];

            $testCmds = array_map(
                function ($cmd) {
                    return preg_replace('/develop|dev/', 'test', $cmd);
                },
                $devCmds
            );

            $handler = function ($type, $buffer) use ($event) {
                $event->getIO()->write($buffer, false);
            };

            foreach ([$devCmds, $testCmds] as $cmds) {
                list($createEnvironment, $migrate) = $cmds;

                (new Process($createEnvironment))->run($handler);
                (new Process($migrate))->run($handler);
            }
        }
    }

    /**
     * Returns the current php executable
     *
     * @return false|string
     */
    protected static function getPhpExecutable()
    {
        return (new PhpExecutableFinder())->find();
    }
}

<?php

use Lurker\Event\FilesystemEvent;
use Lurker\ResourceWatcher;

$watcher = new ResourceWatcher;
$watcher->track('files', __DIR__.'/../src');
$watcher->track('files', __DIR__.'/../app');
$watcher->track('files', __DIR__.'/../mock');
$watcher->track('files', __DIR__.'/../features');
$watcher->addListener('files', function (FilesystemEvent $event) {
    $output = '';
    $command = __DIR__.'/../bin/behat.bat -p delivery --tags @CreateAccount';
    system($command, $output);
    echo $output."\n";
});

return $watcher;

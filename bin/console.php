<?php

if(isset($argv[1]) && $argv[1] === 'cache:clear')
{
    echo 'Clearing Cache started...' . PHP_EOL;

    $count = 0;
    foreach( glob("cache/*") as $file ) {
        if($file !== '.gitignore'){
            unlink($file);
            $count++;
        }
    }

    echo 'Cache cleared sucessfully! Files deleted: ' . $count . PHP_EOL;
    return;
}

$commandList[] = ['command' => 'cache:clear', 'description' => 'Clear Cache Directory. Cache has to be rebuilt!'];

echo 'Commands List:' . PHP_EOL;
foreach ($commandList as $command)
{
    echo '"' . $command['command'] . '" -> ' . $command['description'] . PHP_EOL;
}

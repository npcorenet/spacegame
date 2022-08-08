<?php

function cacheClear()
{
    echo 'Clearing Cache started...' . PHP_EOL;

    $count = 0;
    foreach (glob("cache/*") as $file) {
        if ($file !== '.gitignore') {
            unlink($file);
            $count++;
        }
    }

    echo 'Cache cleared sucessfully! Files deleted: ' . $count . PHP_EOL;
}

function baseInstall()
{
    echo 'Downloading Composer...' . PHP_EOL;

    $composerUri = 'https://getcomposer.org/download/latest-stable/composer.phar';
    $fileName = basename($composerUri);
    if (file_put_contents(__DIR__ . '/../' . $fileName, file_get_contents($composerUri))) {
        chmod(__DIR__ . '/../composer.phar', 0755);
        echo 'Downloaded composer, installing dependencies...' . PHP_EOL;

        exec($_SERVER['_'] . ' composer.phar update', $output, $code);

        if ($code !== 0) {
            echo 'Could not install required Packages. Please check if composer.phar in your root directory has the right permissions!' . PHP_EOL;
            echo 'You can try to manually install the Packages by using the following command:' . PHP_EOL;
            echo 'php ./composer.phar update' . PHP_EOL . PHP_EOL;
            echo 'Error: ' . var_dump($output) . PHP_EOL;
            return;
        }

        echo 'Successfully installed dependencies.' . PHP_EOL;

        return;
    }

    echo 'Could not download Composer, exiting!' . PHP_EOL;
    return;
}

function debugInfo()
{
    var_dump($_SERVER);
}


$commandList['cache:clear'] = [
    'description' => 'Clear Cache Directory. Cache has to be rebuilt!',
    'function' => 'cacheClear'
];
$commandList['base:install'] = [
    'description' => 'Installs the project dependencies',
    'function' => 'baseInstall'
];
$commandList['debug:info'] = [
    'description' => 'Outputs the $_SERVER Variable',
    'function' => 'debugInfo'
];

if (!isset($argv[1])) {
    echo 'Commands List:' . PHP_EOL;
    foreach ($commandList as $command => $content) {
        echo '"' . $command . '" -> ' . $content['description'] . PHP_EOL;
    }

    exit();
}

$command = $argv[1];
if (array_key_exists($command, $commandList)) {
    return $commandList[$command]['function']();
}

echo sprintf('command %s not found', $command) . PHP_EOL;
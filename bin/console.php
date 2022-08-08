<?php

if(isset($argv[1]))
{

    $command = $argv[1];
    if($command === 'cache:clear')
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

    if($command === 'base:install')
    {
        echo 'Downloading Composer...' . PHP_EOL;

        $composerUri = 'https://getcomposer.org/download/latest-stable/composer.phar';
        $fileName = basename($composerUri);
        if(file_put_contents(__DIR__.'/../'.$fileName, file_get_contents($composerUri))) {

            chmod(__DIR__.'/../composer.phar', 0755);
            echo 'Downloaded composer, installing dependencies...' . PHP_EOL;

            exec($_SERVER['_'] . ' composer.phar update', $output, $code);

            if($code !== 0)
            {
                echo 'Could not install required Packages. Please check if composer.phar in your root directory has the right permissions!' . PHP_EOL;
                echo 'You can try to manually install the Packages by using the following command:' . PHP_EOL;
                echo 'php ./composer.phar update'. PHP_EOL . PHP_EOL;
                echo 'Error: ' . var_dump($output) . PHP_EOL;
                return;
            }

            echo 'Successfully installed dependencies.' . PHP_EOL;

            return;

        }

        echo 'Could not download Composer, exiting!' . PHP_EOL;
        return;

    }

    if($command === 'debug:info')
    {
        var_dump($_SERVER);

        return;

    }

}

$commandList[] = ['command' => 'cache:clear', 'description' => 'Clear Cache Directory. Cache has to be rebuilt!'];
$commandList[] = ['command' => 'base:install', 'description' => 'Installs the project dependencies'];
$commandList[] = ['command' => 'debug:info', 'description' => 'Outputs the $_SERVER Variable'];

echo 'Commands List:' . PHP_EOL;
foreach ($commandList as $command)
{
    echo '"' . $command['command'] . '" -> ' . $command['description'] . PHP_EOL;
}

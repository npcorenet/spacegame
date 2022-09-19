<?php

require_once __DIR__.'/../vendor/autoload.php';

\App\Software::loadEnvironmentFile(__DIR__.'/..');
$pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$database = new \Envms\FluentPDO\Query($pdo);

function cacheClear(): void
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

function baseInstall(): void
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

function debugInfo(): void
{
    var_dump($_SERVER);
}

function databaseUpdate(): void
{
    global $database;

    $fileList = ['contracts', 'solar', 'planets'];

    echo 'Updating Database Data from the following files: '. PHP_EOL;
    foreach ($fileList as $item)
    {
        echo "\e[33m/data/" . $item . ".json\e[39m" . PHP_EOL;
    }

    echo PHP_EOL.'Starting Database Data Update...'.PHP_EOL;

    $operations = 0;

    foreach ($fileList as $item)
    {
        $path = __DIR__.'/../data/'.$item.'.json';

        $data = file_get_contents($path);
        $data = json_decode($data, true);

        $newData['lastPush'] = (new DateTime())->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']);
        $newData['table'] = $data['table'];
        foreach ($data['data'] as $contract)
        {

            if($contract['id'] == 0)
            {
                $id = $database->insertInto($data['table'])->values($contract)->execute();
                $contract['id'] = (int)$id;
                $operations++;
            }

            if($contract['id'] > 0)
            {
                $database->update($data['table'])->where('id', $contract['id'])->set($contract)->execute();
                $operations++;
            }

            $newData['data'][] = $contract;
        }

        file_put_contents($path, json_encode($newData, JSON_PRETTY_PRINT));
        echo 'Completed File: data/'.$item.'.json'.PHP_EOL;
    }

    echo 'Completed Database Data update Operation.'.PHP_EOL;
    echo 'Operation Count: ' . $operations . PHP_EOL;

}

function databaseBackup(): void
{
    global $database;
    global $argv;

    if(!isset($argv[2]))
    {
        echo 'Missing which database to backup'.PHP_EOL;
        return;
    }

    $backupTable = $argv[2];
    $data = $database->from($backupTable)->fetchAll();

    if($data === FALSE)
    {
        echo 'Table could not be found'.PHP_EOL;
        return;
    }

    $json['lastPush'] = (new DateTime())->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']);
    $json['table'] = $backupTable;

    foreach ($data as $item)
    {
        $json['data'][] = $item;
    }

    file_put_contents(__DIR__.'/../data/backup/'.$backupTable.'.json', json_encode($json, JSON_PRETTY_PRINT));
    echo 'Backed up Database ' . $backupTable . ' ' .PHP_EOL;
    return;
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
$commandList['database:update'] = [
    'description' => 'Updates the database data from the files defined',
    'function' => 'databaseUpdate'
];
$commandList['database:backup'] = [
    'description' => 'Backups a given Database to json',
    'function' => 'databaseBackup'
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
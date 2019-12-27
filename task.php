<?php
/**
 * 计划任务入口
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

class Task
{
    public function main($argv): int
    {
        if (!isset($argv[1])) print_console('Task name is empty', true);

        $taskName = $argv[1];

        \Scheduled\Core\Tools::writeLog("Task {$taskName} start");

        $fullTaskName = "Scheduled\Tasks\\$taskName";
        $object = new $fullTaskName();
        $object->main($argv);
       return 0;
    }
}

spl_autoload_register('autoload');

function autoload($class)
{
    $dec = strrpos($class, '\\');
    $namespace = mb_substr($class, 0, $dec);
    $className = mb_substr($class, $dec+1);

    $className = namespace_reflect($namespace) . '/' . $className . '.php';

    include_once $className;
}

function namespace_reflect($namespace)
{
    $namespaces = [
        'Scheduled\Core' => __DIR__ . '/core',
        'Scheduled\Tasks' => __DIR__ . '/tasks',
    ];
    return $namespaces[$namespace] ?? '';
}

function print_console($msg, $exit = false)
{
    if ($exit) exit($msg . PHP_EOL);

    echo $msg . PHP_EOL;
}


$task = new Task();
exit($task->main($argv));

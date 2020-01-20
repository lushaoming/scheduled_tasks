<?php
/**
 * 计划任务入口
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
define('ABS_PATH', true);

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

/**
 * 自动加载
 * @param $class
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/28
 */
function autoload($class)
{
    $dec = strrpos($class, '\\');
    $namespace = mb_substr($class, 0, $dec);
    $className = mb_substr($class, $dec+1);

    $classPath = namespace_reflect($namespace);

    if ($classPath != null) {
        $className = $classPath . '/' . $className . '.php';

        include_once $className;
    }
}

/**
 * 命名空间映射
 * @param $namespace
 * @return mixed|string
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/28
 */
function namespace_reflect($namespace)
{
    $namespaces = [
        'Scheduled\Core' => __DIR__ . '/core',
        'Scheduled\Tasks' => __DIR__ . '/tasks',
        'Scheduled\Facade' => __DIR__ . '/interface',
    ];
    return $namespaces[$namespace] ?? null;
}

/**
 * 控制台输出
 * @param $msg
 * @param bool $exit
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/28
 */
function print_console($msg, $exit = false)
{
    if ($exit) exit($msg . PHP_EOL);

    echo $msg . PHP_EOL;
}


$task = new Task();
exit($task->main($argv));

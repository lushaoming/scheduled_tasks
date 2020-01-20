<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
namespace Scheduled\Core;

use Scheduled\Facade\IController;

abstract class Controller implements IController
{
    abstract public function main($argv): int;
}
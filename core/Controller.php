<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
namespace Scheduled\Core;

abstract class Controller
{
    abstract public function main($argv): int;
}
<?php
/**
 * 测试任务
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
namespace Scheduled\Tasks;

use Scheduled\Core\Controller;
use Scheduled\Core\Tools;

class Test extends Controller
{
    public function main($argv): int
    {
        new Tools();
        return 0;
    }
}
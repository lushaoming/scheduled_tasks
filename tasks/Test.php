<?php
/**
 * 测试任务
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
namespace Scheduled\Tasks;
use Scheduled\Core\Controller;
use Scheduled\Core\DB;
class Test extends Controller
{
    public function main($argv): int
    {
        // 查询用户表
        $users = DB::selectAll('SELECT * FROM `users` WHERE `id`<100');
        // 使用?占位符
        DB::executeSql('UPDATE `users` SET `age`=? WHERE `id`<?', [21, 100]);
        // 使用命名占位符
        DB::executeSql('UPDATE `users` SET `age`=:age WHERE `id`<:id', ['age' => 21, 'id' => 100]);

        return 0;
    }
}
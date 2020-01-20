# Scheduled Tasks

## 使用方式

- PHP >= 7.1.1
- 拉取项目后需要执行composer update。
- logs文件夹需要写的权限

执行命令：

```shell
# php task.php 任务类名称 参数1 参数2 ...
```

参数是可选的，如：

```shell
# php task.php ExpireOrder
```

可在crontab中设置：

```shell
# */1 * * * * /usr/bin/php /www/tasks/task.php ExpireOrder
```

## 如何编写计划任务类

> - 所有计划任务类都应该放在tasks文件夹下
> - 所有计划任务类的命名空间都应该是Scheduled\Tasks
> - 所有计划任务类都应该继承Scheduled\Core\Controller
> - 所有计划任务类都应该有个public 的main($argv)方法并且返回int类型的值（推荐返回0）

示例代码：
```php
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
```

## 未完成功能

- Redis操作

#### 如有疑问，请发送邮件到lushaoming6@gmail.com，看到会回复。
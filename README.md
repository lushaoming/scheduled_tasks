# Scheduled Tasks

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


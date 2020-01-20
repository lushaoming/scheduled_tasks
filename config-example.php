<?php
/**
 * 配置文件
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
if (!defined('ABS_PATH')) exit(0);

const BASE_CONFIG = [
    'env' => 'develop',
    'log_file' => __DIR__.'/logs/log.txt',
    'db' => [
        // 主机地址
        'host' => '127.0.0.1',
        // 数据库端口
        'port' => 3306,
        // 用户名
        'username' => 'root',
        // 数据库密码
        'password' => 'Lu!@admin001',
        // 数据库名
        'db_name' => 'reolink',
        // 数据库表前缀
        'prefix' => 'reo_',
        // 数据库调试模式
        'debug' => true,
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => ''
    ],
    'email_senders' => [
        'default' => 'default',
        'no_reply' => 'xxxxx@qq.com'
    ],
    'email_accounts' => [
        'default' => [
            'account' => 'xxxxx@qq.com',
            'password' => 'xxxxx',
            'name' => 'xxxxx@qq.com'
        ],
        'xxxxx@qq.com' => [
            'account' => 'xxxxx@qq.com',
            'password' => 'xxxxxxxxx',
            'name' => 'xxxxx@qq.com'
        ]
    ],
    'email_server' => [
        'host' => 'smtp.qq.com',
        'port' => 465,
        'secure' => 'ssl',
        'auth' => true
    ],
    'email_reply_to' => 'xxxxx@qq.com'
];
<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/28
 */
namespace Scheduled\Core;

use Bryce\Logger\Logger;
use Scheduled\Facade\IDB;

class DB implements IDB
{
    public static $pdo = null;

    public static function init()
    {
        if (is_null(self::$pdo)) {
            self::setDbConfig();
        }
    }

    public static function setDbConfig(): void
    {
        $dns = 'mysql:host='.BASE_CONFIG['db']['host'].':'.BASE_CONFIG['db']['port'].';dbname='.BASE_CONFIG['db']['db_name'];
        try {
            self::$pdo = new \PDO($dns, BASE_CONFIG['db']['username'], BASE_CONFIG['db']['password']);
        } catch (\PDOException $e) {
            Logger::init()->write($e->getMessage());
            exit('Failed to connect mysql server, see detail in '.Logger::init()->getLogFile());
        }
    }

    /**
     * 执行一条查询语句
     * @param $sql
     * @return array
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2020/1/20
     */
    public static function selectAll($sql)
    {
        self::init();

        try {
            $ps = self::$pdo->prepare($sql);
            //执行SQL语句
            $ps->execute();
            $rows = $ps->fetch();
            if ($rows === false) {
                return [];
            }
            // 除去数字索引
            foreach ($rows as $key => $row) {
                if (is_int($key)) unset($rows[$key]);
            }
            return $rows;
        } catch (\PDOException $e) {
            Logger::init()->write($e->getMessage());
            exit('Failed to execute the sql: '.$sql.', see detail in '.Logger::init()->getLogFile());
        }

    }

    /**
     * 执行一条SQL语句，对查询无效
     * @param string $sql 执行的SQL语句
     * @param array $params 绑定参数
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2020/1/20
     */
    public static function executeSql($sql, $params = [])
    {
        /**
         * 使用命名占位符：INSERT INTO REGISTRY (name, value) VALUES (:name, :value)，则绑定参数的格式为：['name' => 'Bryce', 'value' => 20]
         * 使用 ? 占位符：INSERT INTO REGISTRY (name, value) VALUES (?, ?)，则绑定参数格式为：['Bryce', 20]
         */
        self::init();

        try {
            $stmt = self::$pdo->prepare($sql);
            if (count($params) > 0) {
                foreach ($params as $key => $value) {
                    if (is_string($key)) $key = ":{$key}";
                    $stmt->bindParam($key, $value);
                }
            }
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            Logger::init()->write($e->getMessage());
            exit('Failed to execute the sql: '.$sql.', see detail in '.Logger::init()->getLogFile());
        }

    }


}
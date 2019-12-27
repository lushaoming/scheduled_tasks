<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/27
 */
namespace Scheduled\Core;

use Bryce\Logger\Logger;

class Tools
{
    /**
     * @param $data
     * @param int $level
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/27
     */
    public static function writeLog($data, $level = 1)
    {
        if (is_array($data)) $data = json_encode($data);
        Logger::init(['file' => LOG_FILE])->write($data, $level);
    }
}
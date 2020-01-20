<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/30
 */
namespace Scheduled\Tasks;

use Scheduled\Core\Controller;
use Scheduled\Core\Email;

class SendEmail extends Controller
{
    public function main($argv): int
    {
        // TODO: Implement main() method.
        $mail = new Email();
        $mail->sender = 'default';
        $result = $mail->send('lusm@sz-bcs.com.cn', 'This is a test email', 'Do not reply');
        if ($result) echo 'Success'.PHP_EOL;
        else echo 'Failed, please view log'.PHP_EOL;

        return 0;
    }
}
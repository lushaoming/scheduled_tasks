<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/28
 */
namespace Scheduled\Core;

use Bryce\Logger\Logger;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $sender;

    public function send($to, $subject, $body, $attachments = [], $saveLog = true)
    {
        try {
            if (!$this->sender) {// 没有设置发送邮箱，则使用默认的
                $this->sender = BASE_CONFIG['email_senders']['default'];
            }

            if (!isset(BASE_CONFIG['email_accounts'][$this->sender])) {
                throw new \Exception('No email account');
            }

            $account = BASE_CONFIG['email_accounts'][$this->sender];

            $mail = new PHPMailer();
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();

            $mail->Host = BASE_CONFIG['email_server']['host'];                // SMTP服务器
            $mail->SMTPAuth = BASE_CONFIG['email_server']['auth'];                      // 允许 SMTP 认证
            $mail->Username = $account['account'];                // SMTP 用户名  即邮箱的用户名
            $mail->Password = $account['password'];             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = BASE_CONFIG['email_server']['secure'];                    // 允许 TLS 或者ssl协议
            $mail->Port = BASE_CONFIG['email_server']['port'];                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom($account['account'], $account['name']);  //发件人

            if (is_array($to)) {
                $mail->addAddress($to[0], $to[1]);  // 收件人
            } else {
                $mail->addAddress($to);  // 收件人
            }

            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            $mail->addReplyTo(BASE_CONFIG['email_reply_to']); //回复的时候回复给哪个邮箱 建议和发件人一致
            //$mail->addCC('cc@example.com');                    //抄送
            //$mail->addBCC('bcc@example.com');                    //密送

            if (count($attachments) > 0) {
                foreach ($attachments as $attachment) {
                    if (is_array($attachment)) {
                        $mail->addAttachment($attachment[0], $attachment[1]);
                    } else {
                        $mail->addAttachment($attachment);
                    }
                }
            }

            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $subject;
            $mail->Body    = $body;
//            $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

            if ($mail->send()) {
                if ($saveLog) $this->saveLog(true, $account['account'], is_array($to) ? $to[0] : $to);
                return true;
            } else {
                if ($saveLog) $this->saveLog(false, $account['account'], is_array($to) ? $to[0] : $to, $mail->ErrorInfo);
                return false;
            }
        } catch (\Exception $e) {
            if ($saveLog) $this->saveLog(false, $account['account']??'None', is_array($to) ? $to[0] : $to, $e->getMessage());
            return false;
        }
    }

    private function saveLog($result, $account, $to, $msg = '')
    {
        Logger::init(BASE_CONFIG['log_file'])->write($result ? 'Success' : 'Failed' . '. Sender: '.$account.', To: '.$to.'. '.$msg);
    }
}
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use PHPMailer\PHPMailer\PHPMailer;
function sendmail($tomail,$title,$body)
{
	$mail=new PHPMailer();
	$toemail = $tomail;//定义收件人的邮箱
	$mail->isSMTP();// 使用SMTP服务
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = "phpmelove@163.com";// 发送方的邮箱用户名，就是自己的邮箱名
    $mail->Password = "w937978402";// 第三方授权码,
    //$mail->SMTPSecure = "ssl";// 使用ssl协议方式,
    $mail->Port = 25;// QQ邮箱的ssl协议方式端口号是465/587

    $mail->setFrom("phpmelove@163.com","网易云邮箱");// 设置发件人信息，如邮件格式说明中的发件人,
    $mail->addAddress($tomail,'猪猪');// 设置收件人信息，如邮件格式说明中的收件人
    $mail->addReplyTo("phpmelove@163.com","Reply");
    $mail->Subject = $title;// 邮件标题
    $mail->Body = $body;// 邮件正文

    if(!$mail->send()){// 发送邮件
        echo "Message could not be sent.";
        echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
    }else{
        echo '发送成功';
    }
    }

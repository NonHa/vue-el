<?php
// use sinacloud\sae\Storage as Storage;

define("FROM", "yipiaohunlian@sina.com");		//发送邮箱
define("USERNAME", "yipiaohunlian");			//发送用户名
define("PWD", "fd2d5a336d468017");			//邮箱密码
define("HOST", "smtp.sina.com");				//主机
define("POST", 25);				//
define("TLS", false);				//

class EmailUtil {   
	
	protected $to;		//发送给
	protected $error;
	
	function __construct($arg1){
		$this->to = $arg1;
	}
	
	function __destruct()
	{
	    
	}
	
	public function getError(){
		return $this->error;
	}
	
	/**
	 * @param {Object} $to
	 * @param {Object} $emailOperate
	 * @param {Object} $checkCode
	 */
	public function sendCheckCode($emailOperate,$checkCode){
		$subject = "一瓢婚恋网邮箱验证";
		$content = "【一瓢婚恋网】 您正在进行“".$emailOperate."”操作！验证码为：".$checkCode."。10分钟之内有效。如非本人操作，请前往 www.yipiaohunlian.com 修改密码。";
		$mail = new SaeMail();
		$ret = $mail->quickSend($this->to, $subject, $content, FROM, PWD);
		if ($ret === false) {$this->error=$mail->errmsg();}
		$mail->clean(); //重用此对象
		return $ret;
	}
	
	public function sendNotice($content){
		$subject = "一瓢婚恋通知";
		$arr = array("from"=>FROM, "to"=>$this->to, "subject"=>$subject, "content"=>$content, "content_type"=>"HTML", "smtp_username"=>USERNAME, "smtp_password"=>PWD,"smtp_host"=>HOST, "smtp_port"=>PORT, "tls"=>TLS);
		$mail = new SaeMail($arr);
		$ret = $mail->send();
		// $ret = $mail->quickSend($email, $subject, $content, "15575986698@163.com", "GIAIZLXKPQYQZLFN");
		//发送失败时输出错误码和错误信息
		if ($ret === false) {$this->error=$mail->errmsg();}
		$mail->clean(); //重用此对象
		return $ret;
	}
	
}
?>
<?php
// use sinacloud\sae\Storage as Storage;
require __DIR__ . "/resource/qcloudsms/src/index.php";

use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsVoiceVerifyCodeSender;
use Qcloud\Sms\SmsVoicePromptSender;
use Qcloud\Sms\SmsStatusPuller;
use Qcloud\Sms\SmsMobileStatusPuller;

use Qcloud\Sms\VoiceFileUploader;
use Qcloud\Sms\FileVoiceSender;
use Qcloud\Sms\TtsVoiceSender;


define("SMS_APPID", 1400402779);		//发送邮箱
define("SMS_APPKEY", "fe6d11e95e29b024c893cd527ae5eb62");			//发送用户名
define("SMS_SMSSIGN", "一瓢婚恋");			//邮箱密码

class SmsUtil {   
	
	// protected $phoneNumber;		//发送给
	// protected $templateId;		
	protected $error;
	
	function __construct(){
		// $this->phoneNumber = $arg1;
	}
	
	function __destruct()
	{
	    
	}
	
	public function getError(){
		return $this->error;
	}
	
	public function isCheckCode($phoneNumber,$checkCode){
		$mmc = new Memcached();
		if ($mmc == false) {
			$this->error = "Memcached init failed";
			return false;
		} else {
			$key = strval($phoneNumber).strval($checkCode);
			$value = $mmc->get($key);
			if($value==$checkCode){
				return true;
			}else{
				$this->error = "验证码错误";
				return false;
			}
		}
		return false;
	}
	
	/**
	 * @param {Number} $phoneNumber 电话
	 * @param {Object} $params 内容参数
	 * @param {Number} $templateId 腾讯云模板ID
	 */
	public function sendSms($phoneNumber,$params,$templateId){
		try {
		    //发一个提醒消息，不用Memcache
		    $ssender = new SmsSingleSender(SMS_APPID, SMS_APPKEY);
		    $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,
		        $params, SMS_SMSSIGN, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
		    $rsp = json_decode($result,true);
			// if($rsp["result"]===0){
			// 	return true;
			// }else{
			// 	$this->error=$rsp["errmsg"];
			// 	return false;
			// }
			return $rsp;
		} catch(\Exception $e) {
			$this->error=$e;
		    return false;
		}
		
	}
	
	/**
	 * @param {Object} $phoneNumber[array]
	 */
	public function sendUpdatePWDCheckCode($phoneNumber,$checkCode){
		$templateId=667862;
		try {
		    $ssender = new SmsSingleSender(SMS_APPID, SMS_APPKEY);
		    //参数
			$params = array($checkCode);
		    $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,
		        $params, SMS_SMSSIGN, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
		    $rsp = json_decode($result,true);
			
			
			if($rsp["result"]===0){
				$mmc = new Memcached();
				if ($mmc == false) {
					$this->error="Memcached init failed\n";
					return false;
				} else {
					$key = strval($phoneNumber).strval($checkCode);
					$mmc->set($key, $checkCode,time()+5*60);
				}
				return true;
				
			}else{
				$this->error=$rsp["errmsg"];
				return false;
			}
		} catch(\Exception $e) {
			$this->error=$e;
		    return false;
		}
	}
	
	
	
	/**
	 * @param {Object} $phoneNumber[array]
	 */
	public function sendUpdateTelCheckCode($phoneNumber,$checkCode){
		$templateId=667860;//修改注册手机号码
		try {
		    $ssender = new SmsSingleSender(SMS_APPID, SMS_APPKEY);
		    //参数
			$params = array($checkCode);
		    $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,
		        $params, SMS_SMSSIGN, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
		    $rsp = json_decode($result,true);
			
			
			if($rsp["result"]===0){
				$mmc = new Memcached();
				if ($mmc == false) {
					$this->error="Memcached init failed\n";
					return false;
				} else {
					$key = strval($phoneNumber).strval($checkCode);
					$mmc->set($key, $checkCode,time()+5*60);
				}
				return true;
				
			}else{
				$this->error=$rsp["errmsg"];
				return false;
			}
		} catch(\Exception $e) {
			$this->error=$e;
		    return false;
		}
	}
	
	/**
	 * @param {Object} $phoneNumber[array]
	 */
	public function sendAddTelCheckCode($phoneNumber,$checkCode){
		$templateId=567371;//注册验证码
		try {
		    $ssender = new SmsSingleSender(SMS_APPID, SMS_APPKEY);
		    //参数
			$params = array($checkCode);
		    $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,
		        $params, SMS_SMSSIGN, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
		    $rsp = json_decode($result,true);
			
			
			if($rsp["result"]===0){
				$mmc = new Memcached();
				if ($mmc == false) {
					$this->error="Memcached init failed\n";
					return false;
				} else {
					$key = strval($phoneNumber).strval($checkCode);
					$mmc->set($key, $checkCode,time()+5*60);
				}
				return true;
				
			}else{
				$this->error=$rsp["errmsg"];
				return false;
			}
			
		} catch(\Exception $e) {
			$this->error=$e;
		    return false;
		}
	}
}
?>
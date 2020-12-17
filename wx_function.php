<?php
define("APPID", "wx5ad31ac1cd33fc05");
define("APPKEY", "a7373a8b4c6e2883e93b3fcf7cbaabaa");

define("APPURL", "http://hr.sinlun.com");
define("SUBSCRIBE_PAGE", "/pages/subscribe.html");

define("TEMPMSG_BIND", "DmIpZrLFAqGthNr_8ism8Xjs5_psbePpZmSbLpntIBA"); //绑定成功通知

class wechatFunction
{ 
   var $mmc;

   function wechatFunction()
   {
		$this->mmc = memcache_init();
   }
   
	public function GetUserInfo( $openid)
	{
		$token = $this->GetAccessToken();
		$rand = rand(123456,987654);
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN&r=".$rand;
		return $this->httpGet($url);
	}
	
	public function getSignPackage( $url = '' ) {
		$jsapiTicket = $this->getJsApiTicket();

		//注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		//$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url = $url?$url:("$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); 
        
		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		$signature = sha1($string);
		$signPackage = array(
			"appId"     => APPID,
			"nonceStr"  => $nonceStr,
			"timestamp" => $timestamp,
			"url"       => $url,
			"signature" => $signature,
			"rawString" => $string,
		);
		return $signPackage; 
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
    
    public function getQscodeTicket( $id ) {
        $accessToken = $this->GetAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$accessToken;
		$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
		$PostResult = $this->http_request($url,$data); 
		if(strpos($PostResult, "errcode") ){
			$accessToken = $this->GetAccessToken2(1); 
			$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$accessToken;
			$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
			$PostResult = $this->http_request($url,$data); 
		}	
		$json = json_decode($PostResult);
		return $json->ticket; 
    }

	private function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新
		$data = json_decode(memcache_get($this->mmc,"jsapi_ticket"));
		if(!$data)$data = json_decode('{"jsapi_ticket":"","expire_time":0}');
		if ($data->expire_time < time()) {
			$accessToken = $this->GetAccessToken();
			// 如果是企业号用以下 URL 获取 ticket
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
			$res = json_decode($this->httpGet($url));
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				memcache_set($this->mmc,"jsapi_ticket",json_encode($data));
			}
		} else {
			$ticket = $data->jsapi_ticket;
		}
		return $ticket;
	}

	public function GetAccessToken() {
		return $this->GetAccessToken2(0);
	}
	public function GetAccessToken2( $reload ) {
		// access_token 应该全局存储与更新
		if($this->mmc==false)return "";
		$data = json_decode(memcache_get($this->mmc,"access_token"));
		if(!$data)$data = json_decode('{"access_token":"","expire_time":0}');
		if( ($data->expire_time < time()) || ($reload>0) ){
			// 如果是企业号用以下URL获取access_token
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPKEY;
			$res = json_decode(  $this->httpGet($url) );
			$access_token = $res->access_token;
			if ($access_token) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				memcache_set($this->mmc,"access_token",json_encode($data));
			}
		} else {
			$access_token = $data->access_token;
		}
		return $access_token;
	}
  
	//GET数据 取access_token用
	public function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
		// 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
		curl_setopt($curl, CURLOPT_URL, $url);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	}
  
   //POST数据 修改菜单,发送模版消息用
	public function http_request($url, $data = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

	//获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
	public function GetEditAddressParameters($access_token)
	{	
		$data = array();
		$data["appid"] =  APPID;
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $access_token;
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => APPID,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}	
	
	//拼接签名字符串 * @return 返回已经拼接好的字符串
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}

    //发送模版消息
   	public function SendTempMsg($tempid,$openid,$data)
    {
        $token =  $this->GetAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        
        $temp = array('touser' => $openid,
				'template_id' => $tempid,
				'url' => $data["url"],
			    'topcolor' => "#FF0000",
			    'data' => array('first' => array( 'value' =>$data["first"],
												  'color' => "#173177",
											),
								'keyword1' => array( 'value' => $data["keyword1"],
													'color' => "#173177",
											),
								'keyword2' => array( 'value' => $data["keyword2"],
													'color' => "#173177",
											),
                                'keyword3' => array( 'value' => $data["keyword3"],
													'color' => "#173177",
											),
								'keyword4' => array( 'value' => $data["keyword4"],
													'color' => "#173177",
											),
                                'keyword5' => array( 'value' => $data["keyword5"],
													'color' => "#173177",
											),
								'keyword6' => array( 'value' => $data["keyword6"],
													'color' => "#173177",
											),
								'remark' => array( 'value' => $data["remark"],
													'color' => "#173177",
											)
							)
				);
		$json = json_encode($temp);
    	$PostResult = $this->http_request($url,$json);        
    }
	
	//发送模版消息
	public function SendTempMsg2($tempid,$openid,$data)
	{
	    $token =  $this->GetAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
	    
	    $temp = array('touser' => $openid,
				'template_id' => $tempid,
				'url' => $data["url"],
			    'topcolor' => "#FF0000",
			    'data' => array('first' => array( 'value' =>$data["first"],
												  'color' => "#173177",
											),
								'name' => array( 'value' => $data["name"],
													'color' => "#173177",
											),
								'sex' => array( 'value' => $data["sex"],
													'color' => "#173177",
											),
	                            'tel' => array( 'value' => $data["tel"],
													'color' => "#173177",
											),
								'keyword4' => array( 'value' => $data["keyword4"],
													'color' => "#173177",
											),
	                            'keyword5' => array( 'value' => $data["keyword5"],
													'color' => "#173177",
											),
								'keyword6' => array( 'value' => $data["keyword6"],
													'color' => "#173177",
											),
								'remark' => array( 'value' => $data["remark"],
													'color' => "#173177",
											)
							)
				);
		$json = json_encode($temp);
		$PostResult = $this->http_request($url,$json);        
	}
    
    
 }
?>
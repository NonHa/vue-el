<?php
/////////////////////////////////////////
//
//      微信公众号粉丝身份验证
//      go.php    
//
//      (验证用户身份，然后转跳到指定网页)
/////////////////////////////////////////
session_start();
require_once "wx_function.php";
require_once "fun.php";

	$html = $_GET['u'];
	$str = $_SERVER["QUERY_STRING"];
    $m = strpos($str,'&');
    if($m===false)$str = "";
    else $str = "?".substr($str,$m+1);
	if("index.html"==$html){
		$gourl = "http://".$_SERVER['HTTP_HOST']."/".$html.$str;
	}else if($html==true){
		$gourl = "http://".$_SERVER['HTTP_HOST']."/pages/".$html.$str;
	}
	$html2 = $_GET['w'];
	if($html2==true){
		$gourl = "http://".$_SERVER['HTTP_HOST']."/elm/#/".$html2.$str;
	}
	
	if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
        $fun = new userRecord();
		$row = $fun->GetOne($userid);
        if($row===false){
            unset($_SESSION['userid']);
        }
        else {
            $_SESSION['openid'] = $row["openid"];
			$_SESSION['nickname'] = $row["nickname"];
			$_SESSION['photo'] = $row["photo"];
			$_SESSION['sex'] = $row["sex"];
			$_SESSION['tel'] = $row["tel"];
			$_SESSION['isvip'] = $row["isvip"];
            header("Location:".$gourl);
            exit();
        }
	}

	if( isset($_GET['code'])) {
        $code = $_GET['code'];
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPKEY."&code=".$code."&grant_type=authorization_code";
		$wxfun = new wechatFunction();
		$str = $wxfun->httpGet($url);

		$jsondecode = json_decode($str);
		$_SESSION['OAUTH_ACCESS_TOKEN'] = $jsondecode->access_token;
		$openid = $jsondecode->openid;      //用户唯一标识
		if(strlen($openid)<8){  //授权登录失败
			echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" /></head><body>授权登录无法完成，可能是微信服务器被挤爆了，稍后再试吧！</body></html>';			
			exit;
		} 
        
        $fans = new userRecord();
        $row = $fans->FindOne("openid",$openid);
        if($row===false){ //数据库中查无此人
            
            //启动补救程序，部分用户关注时不能写数据库
			$str = $wxfun->GetUserInfo($openid);
			$jsondecode = json_decode($str);
        	if(!$jsondecode->nickname){
            	//保存错误日志
            	unset($fans);
            	$fun = new errorRecord();
           	 	$fun->Save(1,$openid); //未关注
                //返回关注页
            	// header( "Location:".APPURL.SUBSCRIBE_PAGE );
				header( "Location:"."http://".$_SERVER['HTTP_HOST'].SUBSCRIBE_PAGE );
				exit;
        	}
            //添加用户
            $uid = $fans->AddFans( $openid );
        	if(!$uid){
            	unset($fans);
            	$fun = new errorRecord();
            	$fun->Save(2,$openid); //添加错误
            	exit;
        	}
            //更新用户基本信息
			$nickname = urlencode($jsondecode->nickname);
			$sex = $jsondecode->sex;
			$photo = urlencode($jsondecode->headimgurl);
            $result = $fans->UpdateFans($uid,$nickname,$photo,$sex);
            if($result==false){
                unset($fans);
            	$fun = new errorRecord();
            	$fun->Save(3,$openid); //拉信息错误
            }
        } 
		
        $_SESSION['userid'] = $row["id"];
        $_SESSION['openid'] = $row["openid"];
		$_SESSION['nickname'] = $row["nickname"];
		$_SESSION['photo'] = $row["photo"];
		$_SESSION['sex'] = $row["sex"];
		$_SESSION['tel'] = $row["tel"];
		$_SESSION['isvip'] = $row["isvip"];
		unset($fun);
		$fun = new logRecord();
		$row2 = $fun->addOne($row["openid"],"login");
		unset($fun);
        header("Location:".$gourl);
	}
	else {  //去找微信要CODE
		$link = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".$link."&response_type=code&scope=snsapi_base&state=0#wechat_redirect";
        header("Location:".$url);
		exit;
	}


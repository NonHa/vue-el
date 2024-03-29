<?php
/////////////////////////////////////////
//
//      网页前端 API接口
//
////////////////////////////////////////
session_start();
require_once "wx_function.php";
require_once "fun.php";
require_once "email_util.php";
require_once "sms_util.php";
use sinacloud\sae\Storage as Storage;

    $err = 0;
    $msg = "操作成功!";
    $result = "";
    $times = 0;
	
	$arr = array('Code'=>0);
	//如果没有COOKIE['IdxCity']则设置默认184
	if(!isset($_COOKIE['IdxCity']))setcookie('IdxCity', 184,time()+60*60,'/');
	
	if(strval($_POST['api_test_2'])==="yipiao_api_test"){
		$userid = 1;
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
		}
	}
	
	if(!isset($_POST['operate']))$arr = array('Code'=>102,'Msg'=>"未指定任何操作!",'Result'=>"");
	else {
        if(isset($_COOKIE['IdxCity']))$city_id = $_COOKIE['IdxCity'];//地址数值
		else $city_id=184;
    	$operate = $_POST["operate"];
        if(isset($_SESSION['userid']))$userid = $_SESSION['userid'];
        else $userid = 0;
        
        if(isset($_SESSION['openid']))$openid = $_SESSION['openid'];  
		else $openid = "";
    }

	if($arr['Code']>0){
    	$str = json_encode($arr);
		echo $str;
    	exit();
    }

	switch( $operate ){
		case "getSession":
		    $result = "";
			break;
        case "getwxSign":
            $url = urldecode($_POST["url"]);
            $wxsdk = new wechatFunction();
            $signPackage = $wxsdk->GetSignPackage( $url );
			$signPackage["accessToken"] = $wxsdk->GetAccessToken();
            $signPackage["userid"] = $userid;
            $result = json_encode($signPackage);
			break;
        case "getQrcode":
            $id = $_POST['id'];
            $wxsdk = new wechatFunction();
            $result = $wxsdk->getQscodeTicket( $id );
            break;
        //网页版登录
        case "GetChannel": //注册时创建长连接
			$channel = new SaeChannel();
        	$token = $_POST["token"];
        	if($token==false){$err = 9999;$result = "";}
			else {
				$result = $channel->createChannel($token);         
				if($result==false){
					$result=$channel->errmsg();     
				}
				// $result=$result."  ***errmsg：".$channel->errmsg();     
				// $result=$result."  ***errno：".$channel->errno();
			}   
			break;
       case "WebScan": //网页扫描登录
            $token = $_POST["token"];
        	$fun = new userRecord();
			$row = $fun->GetOne($userid);
            if($row===false)$ary = array("uid"=>0, "timestamp"=>0, "token"=>"");
            else {
        		//生成动态认证token
        		$now = time();
        		$access_token = MD5($now.PWKEY.$userid);
        		$ary = array( "uid"=>$userid, "timestamp"=>$now, "token"=>$access_token);
            }
            //向登录页面推送数据  
            $str = json_encode($ary);
        	$channel = new SaeChannel();			
        	$channel->sendMessage($token,$str); 
            break;
		
        case "WebLogin": //网页扫描登录 
            $timestamp = $_POST["timestamp"];
            $token = $_POST["token"];
            $uid = $_POST["uid"];
            $now = time();
            if($now - $timestamp >60){$err = 11;break;}
            $access_token = MD5($timestamp.PWKEY.$uid);
            if($access_token != $token){$err = 12;break;}
            $fun = new userRecord();
			$row = $fun->GetOne($uid);
            if($row===false){$err = 1;break;}
            $_SESSION['userid'] = $row["id"];
        	$_SESSION['openid'] = $row["openid"];
			$_SESSION['nickname'] = $row["nickname"];
			$_SESSION['photo'] = $row["photo"];
			$_SESSION['sex'] = $row["sex"];
			$_SESSION['tel'] = $row["tel"];
			$_SESSION['isvip'] = $row["isvip"];
			unset($fun);
			$fun = new logRecord();
			$vipinfo = $fun->addOne($row["openid"],"login");
			unset($fun);
			$result = json_encode($row);
            break;
        case "pwLogin": //网页密码登录 
        	$key = md5($_POST["key"]);
        	$tel = $_POST["tel"];
        	$fun = new userRecord();
			$row = $fun->FindOne("tel",$tel);
            if($row===false){$err = 1;break;}
            else if($row["key"] != $key){$err = 3;break;}
        	$_SESSION['userid'] = $row["id"];
        	$_SESSION['openid'] = $row["openid"];
			$_SESSION['nickname'] = $row["nickname"];
			$_SESSION['photo'] = $row["photo"];
			$_SESSION['sex'] = $row["sex"];
			$_SESSION['tel'] = $row["tel"];
			//用户表添加了一个是否是vip的字段
			$_SESSION['isvip'] = $row["isvip"];
			unset($fun);
			$fun = new logRecord();
			$vipinfo = $fun->addOne($row["openid"],"login");
			unset($fun);
        	$result = json_encode($row);
            break;
        case "exitWeb":
			$fun = new logRecord();
			$vipinfo = $fun->addOne($_SESSION['openid'],"exit");
			unset($fun);
            $_SESSION['userid'] = 0;
        	$_SESSION['openid'] = "";
			$_SESSION['photo'] = "";
			$_SESSION['nickname'] = "";
			$_SESSION['sex'] = 0;
			$_SESSION['tel'] = 0;
			$_SESSION['isvip'] = 0;
            break;
		//图片存储
        case "saveImage":
            $url = $_POST['url']; 
            $file =  $_POST['img'];
            $stor = new Storage();
            $wxsdk = new wechatFunction();
            $input = $wxsdk->httpGet($url);
            $r = $stor->putObject($input, STORAGE_BUCKET, $file);
            if($r){
                $ret = array("newfile"=>$file );
                $result = json_encode($ret);
            }
            else $err = 100;            
        	break;
            
        //首页    
        case "getIndexData":
            $dat = array();
			if($userid == 0)$dat["user"] = array('id'=>0,'openid'=>"",'nickname'=>"游客",'photo'=>"","soldiers"=>0);
            else {
                $fun = new userRecord();
        		$dat["user"] = $fun->GetOne($userid);
            	unset($fun);
            }
            $fun = new setupRecord();
            $dat["public"] = $fun->GetOne(3);
            $dat["hotjob"] = $fun->GetOne(8);
            $dat["neworder"] = $fun->GetOne(9);
			unset($fun);
			$lr = new logRecord();
			$dat["recommander"] = $lr->getTopUser(50);
            // unset($lr);
            $result = json_encode($dat);
        	break;
        
        case "GetMyId":
            $result = $userid;
        	break;  
			
        case "ModifyPassword":
			//登录后修改密码
            if(!$userid){$err = 2; break;}
        	$oldpw = md5($_POST["oldpw"]);
        	$newpw = md5($_POST["newpw"]);
        	$fun = new userRecord();
        	$row = $fun->GetOne( $userid );
        	if($row["key"] != $oldpw){$err = 3;break;}
        	$ary = array('key'=>$newpw);
           	$result = $fun->Update($userid,$ary);
        	if($result){
				//修改成功后发送短信提醒
				$sms = new SmsUtil();
				$res = $sms->sendSms($_SESSION['tel'],array("0731-85052950或0731-85052971"),676390);
				if($res===false){
					$msg = $sms->getError();
					$err = 99;
				}
			}else{
				$err = 4;
			}
			unset($fun);
        	break;
        
		case "pwdChangeWithOpenid":
			//忘记密码后用openid修改
			$openid=$_POST["openid"];
			$newpwd = md5($_POST["newpwd"]);
			$fun = new userRecord();
			$row = $fun->FindOne("openid",$openid);
			if($row){
				$tell = $row["tel"];
				$userid = $row["id"];
				$ary = array('key'=>$newpwd);
				$result = $fun->Update($userid,$ary);
				if($result){
					//修改成功后发送短信提醒
					$sms = new SmsUtil();
					$res = $sms->sendSms($tell,array("0731-85052950或0731-85052971"),676390);
					if($res===false){
						$msg = $sms->getError();
						$err = 99;
					}
				}else{
					$err = 4;
				}
			}else $err = 1;
			unset($fun);
			break;
		
		case "getforgotPwd":
			$tel=$_POST["tel"];
			$sms = new SmsUtil();
			$res = $sms->sendUpdatePWDCheckCode($tel,rand(100000,999999));
			if($res===false){
				$err=99;$msg = $sms->getError();break;
			}
			$result = $res;
			unset($sms);
			break;
			
		case "checkforgotpwd":
			if(!isset($_POST["tel"])){$err=6;break;}
			$tel = $_POST["tel"];
			if(!isset($_POST["checkCode"])){$err=14;break;}
			$checkCode = $_POST["checkCode"];
			$fun = new SmsUtil();
			$isCheckCode = $fun->isCheckCode($tel,$checkCode);
			if($isCheckCode===true){
				//获取到openid
				$user = new userRecord();
				$row = $user->FindOne("tel",$tel);
				$result['openid']=$row['openid'];
			}else{
				$err=99;$msg = $fun->getError();break;
			}
			unset($fun);
			break;
		
		case "orderReservation":
			if($_SESSION['isvip'] == 0){$err=18;break;}
			$tel = $_POST["tel"];
			$name = $_POST["name"];
			$fun = new userRecord();
			$user = $fun->FindOne("tel",$tel);
			if($user){
				$record= new orderRecord();
				$rt = $record->Add($user["openid"],$name,$tel,"reservation");
				if($rt===false){
					$msg = $record->getError();
					$err = 99;
				}
			}else{
				$msg="没有找到用户，请先注册！";
				$err=99;
			}
			break;
		case "GetSlideUrl":
			$fun = new setupRecord();
			$ary = array();
			for($id=4;$id<9;$id++){
			    $ary[] = $fun->GetOne($id);
			}
			$result = json_encode($ary);
			break;
		//得到用户基本资料
        case "getBasicInfo":
            if($userid == 0){$err=2;break;}
			$dat = array();
			
			$fun = new userRecord();
			$dat["user"] = $fun->GetOne($userid);
			unset($fun);
			
        	$fun = new BasicInfoRecord();
        	$dat["basicInfo"] = $fun->FindOne("openid",$openid );
			unset($fun);
			
			$fun = new ImgUrlRecord();
			$dat["img_url"] = $fun->getByLab($openid,"album",false);
			unset($fun);
			
        	$result = json_encode($dat);
        	break;  
		
		case "updateUser":
			if($userid == 0){$err=2;break;}
			$nickname = $_POST["nickname"];
			$sex = $_POST["sex"];
			$tel = $_POST["tel"];
			$fun = new userRecord();
			$userinfo = $fun->FindOne("openid",$openid);
			$id = $userinfo["id"];
			$info=array(
				"openid" => $openid,
				"nickname" => $nickname,
				"tel" => $tel,
				"sex" => $sex
			);
			$row = $fun->Update($id,$info);
			unset($fun);
			if($row ){
				$_SESSION["nickname"]=$nickname;
				$_SESSION["tel"]=$tel;
				$_SESSION["sex"]=$sex;
			}
			$result = json_encode($row);
			break;
		
		case "updateBasicInfo":
		    if($userid == 0){$err=2;break;}
			$birthday = $_POST["birthday"];
			$height = $_POST["height"];
			// $job_addr = $_POST["job_addr"];
			$education = $_POST["education"];
			$graduated_school = $_POST["graduated_school"];
			$marital_status = $_POST["marital_status"];
			$child = $_POST["child"];
			$wanna_child = $_POST["wanna_child"];
			$job = $_POST["job"];
			$salary = $_POST["salary"];
			$house = $_POST["house"];
			$car = $_POST["car"];
			$hometown = $_POST["hometown"];
			$weight = $_POST["weight"];
			$smoke = $_POST["smoke"];
			$drink = $_POST["drink"];
			$constellation = $_POST["constellation"];
			$nation = $_POST["nation"];
			$when_marry = $_POST["when_marry"];
			// $real_name = $_POST["real_name"];
			// $real_edu = $_POST["real_edu"];
			if($_POST["county"])$job_addr = $_POST["county"];
			else if($_POST["county"])$job_addr = $_POST["city"];
			else if($_POST["province"])$job_addr = $_POST["province"];
			else {$err=13;break;}
			$ary=array(
				"birthday" => $birthday,
				"height" => $height,
				"job_addr" => $job_addr,
				"education" => $education,
				"graduated_school" => $graduated_school,
				"marital_status" => $marital_status,
				"child" => $child,
				"wanna_child" => $wanna_child,
				"job" => $job,
				"salary" => $salary,
				"house" => $house,
				"car" => $car,
				"hometown" => $hometown,
				"weight" => $weight,
				"smoke" => $smoke,
				"drink" => $drink,
				"constellation" => $constellation,
				"nation" => $nation,
				"when_marry" => $when_marry,
				"openid" => $openid
			);
			
			$fun = new BasicInfoRecord();
			$basicInfo = $fun->FindOne("openid",$openid);
			if($basicInfo){
				$id = $basicInfo["id"];
				$row = $fun->Update($id,$ary);
			}else{
				$row = $fun->addOne($ary);
			}
			unset($fun);
			$result = json_encode($row);
			break;  
			
		//得到用户择偶条件
        case "getSpouseCondition":
            if($userid == 0){$err=2;break;}
        	$fun = new SpouseSonditionRecord();
        	$row = $fun->FindOne("openid",$openid );
			unset($fun);
        	$result = json_encode($row);
        	break;  
			
		case "updateSpouseCondition":
		    if($userid == 0){$err=2;break;}
			$ary = json_decode($_POST["ary"], true);
			
			$fun = new SpouseSonditionRecord();
			$ss =  $fun->FindOne("openid",$openid);
			if($ss){
				$row = $fun->Update($ss["id"],$ary);
			}else{
				$row = $fun->addOne($openid,$ary);
			}
			unset($fun);
			$ary2["sql"]=$row;
			$ary2["ary"]=$ary;
			$result = json_encode($ary2);
			break;  
			
		//上传图片
		case "addImg":
		    if($userid == 0){$err=2;break;}
			$url = $_POST["url"];
			$lab = $_POST["lab"];
			$fun = new ImgUrlRecord();
			$row = $fun->addOne($openid,$url,$lab);
			unset($fun);
			$result = json_encode($row);
			break;  
			
		case "updateImg":
		    if($userid == 0){$err=2;break;}
			$id = $_POST["id"];
			$photo = $_POST["photo"];
			$ary=array("photo" => $photo);
			$fun = new userRecord();
			$row = $fun->Update($id,$ary);
			unset($fun);
			$_SESSION["photo"]=$photo;
			$result = json_encode($row);
			break;
			
		case "delImg":
		    if($userid == 0){$err=2;break;}
			$id = $_POST["id"];
			$fun = new ImgUrlRecord();
			$img = $fun->GetOne($id);
			$url =json_decode($img["url"],true);
			$row = $fun->DelOne($id);
			unset($fun);
			$stor = new Storage();
			$bucket = "yipiao";
			$uri = substr($url,38);
			$delRes = $stor->deleteObject($bucket,$uri);
			unset($stor);
			$result = json_encode($row);
			break;
			
		case "getVVipList":
		    if($userid == 0){$err=2;break;}
			
			break;
			
		case "getVipList":
		    if($userid == 0){$err=2;break;}
			
			break;	
		
		case "getUserByID":
		    if($userid == 0){$err=2;break;}
			if($_SESSION['isvip'] == 0){$err=18;break;}
			$uid = $_POST["id"];
			$user = new userRecord();
			$row = $user->GetOne($uid);
			$open_id= $row["openid"];
			//要查询open_id先
			$obj["user"]=$row;
			$userbase = new BasicInfoRecord();
			$obj["base"] = $userbase->FindOne("openid",$open_id);
			$album = new ImgUrlRecord();
			$obj["album"] = $album->getByLab($open_id,"album",false);
			$mate = new SpouseSonditionRecord();
			$obj["mate"] = $mate->FindOne("openid",$open_id);
			$vip = new UserVipRecord();
			$obj["vipinfo"] = $vip->FindOne("openid",$open_id);
			$auth = new AuthenticateRecord();
			$authinfo = $auth->FindOne("openid",$open_id);
			if($authinfo){
				$referrer_id = $authinfo["referrer_id"];
				if($referrer_id){
					$referuser = new userRecord();
					$authinfo["referuser"] = $referuser->FindOne("openid",$referrer_id);
					unset($referuser);
				}
			}
			$obj["auth"]=$authinfo;
			unset($user,$userbase,$mate,$album,$auth,$vip);
			$result = json_encode($obj);
			break;
			
		case "getRecommend":
			if($userid == 0){$err=2;break;}
			$sex = $_SESSION["sex"];
			if($sex==1){
				$se=2;//推荐异性用户
			}else{
				$se=1;
			}
			$vip_id = $_POST["type"]; // 1.creater 2.vip3  4.foregin
			$fun = new userRecord();
			$row = $fun->ScreenUser($vip_id,"sex",$se,0,-1);
			unset($fun);
			$result = json_encode($row);
			break;
		
		case "getSearch":
			if($userid == 0){$err=2;break;}
			$key=$_POST["sid"];
			$fun =new userRecord();
			if(is_numeric($key)){
				$row = $fun->ScreenUser(null,"id",$key,0,-1);
			}else{
				$row = $fun->ScreenUser(null,"nickname",$key,0,-1);
			}
			unset($fun);
			$result = json_encode($row);
			break;
		case "preciseSearch":
			if($userid == 0){$err=2;break;}
			$ary = json_decode($_POST["ary"], true);
			$fun = new userRecord();
			$dat =  $fun->preciseSearch($ary);
			unset($fun);
			$result = json_encode($dat);
			break;  
			
		case "getScreen":
			if($userid == 0){$err=2;break;}
			$fun = new userRecord();
			//$row = $fun->ScreenUser(,times,times+30);//一次30条
			$times+=30;
			unset($fun);
			$result = json_encode($row);
			break;
			
		case "sendMsg":
		    if($userid == 0){$err=2;break;}
			if($_SESSION['isvip'] == 0){$err=18;break;}
			$from = $openid;
			$to = $_POST["to"];
			$lab = $_POST["lab"];
			if(isset($_POST["msg_key"]))$msg_key = $_POST["msg_key"];
			switch($lab){
				case "img":
					$url = $_POST["url"];
					$fun = new ImgUrlRecord();
					$msg_key = $fun->addOne($openid,$url,"chat");
					unset($fun);
					break;
				case "video":
					$url = $_POST["url"];
					$fun = new VideoRecord();
					$msg_key = $fun->addOne($openid,$url,"chat");
					unset($fun);
					break;
				case "audio":
					$url = $_POST["url"];
					$fun = new AudioRecord();
					$msg_key = $fun->addOne($openid,$url,"chat");
					unset($fun);
					break;
				case "invite":
					$status = $_POST["status"];
					$addr = $_POST["addr"];
					$meet_time = $_POST["meet_time"];
					$fun = new msgRecord();
					if($status===1||$status==="1"){
						$isInvited = $fun->isInvited($from,$to);
						if($isInvited>0){$err=17;break;}
					}
					unset($fun);
					$fun = new InviteRecord();
					$msg_key = $fun->addOne($status,$addr,$meet_time);
					unset($fun);
					//发送通知
					$remark="您好，有位异性想约您线下见面，请点击前往处理！";
					$tempid = "H54dz10abqDhn4cDh9gjzHhRVWK3vVbCL4qMGxVNh1s";
					$data = array("url"=>"http://www.yipiaohunlian.com/go.php?u=message.html",
									"first"=>"您好，您收到一条新邀约消息，请及时查看。",
									"name"=>urldecode($_SESSION['nickname']),
									"sex"=>$_SESSION['sex']==1?"男":"女",
									"tel"=>$_SESSION['tel'],
									"remark"=>$remark);
					$wx_fuc = new wechatFunction();
					$result= $wx_fuc->SendTempMsg2($tempid,$to,$data);
					break;
				default: break;
			}
			if($isInvited>0){$err=17;break;}
			if($msg_key){
				$fun = new msgRecord();
				$res = $fun->addOne($from,$to,$lab,$msg_key);
				unset($fun);
			}
			
			
			$result = "success";
			break;	
			
			
		case "getMessageCount":
		    if($userid == 0){$err=2;break;}
			$fun = new msgRecord();
			$row["NewInviteMsgCount"] = $fun->NewInviteMsgCount($openid);
			$row["NewNotInviteMsgCount"] = $fun->NewNotInviteMsgCount($openid);
			$row["NewMsgCount"] = $row["NewInviteMsgCount"]+$row["NewNotInviteMsgCount"];
			unset($fun);
			$result = json_encode($row);
			break;	
			
		case "getInviteMsgList":
		    if($userid == 0){$err=2;break;}
			$page = $_POST["page"]-1;
			$fun = new msgRecord();
			$row = $fun->getInviteMsgList($openid,$page,10);
			if($row===false){$err=99;$msg = $fun->GetErrorMsg();}
			unset($fun);
			$result = json_encode($row);
			break;	
		case "getChatMsgList":
		    if($userid == 0){$err=2;break;}
			$page = $_POST["page"]-1;
			$fun = new msgRecord();
			$dat = $fun->getChatMsgList($openid,$page,10);
			if($dat===false){$err=99;$msg = $fun->GetErrorMsg();}
			for($i=0;$i<count($dat);$i++){
				$dat[$i]["msg_count"] = $fun->NewMsgCountByFrom($dat[$i]["from"],$dat[$i]["to"]);
			}
			unset($fun);
			$result = json_encode($dat);
			break;
			
		case "getInviteById":
		    if($userid == 0){$err=2;break;}
			if($_SESSION["isvip"] == 0){$err=18;break;}
			$from = $_POST["from"];
			$fun = new msgRecord();
			$dat = $fun->getInviteById($from,$openid);
			for($i=0;$i<count($dat);$i++){
				if($dat[$i]["to"]==$openid){
					if($dat[$i]["is_read"]==0){
						$fun->Update($dat[$i]["id"],array("is_read"=>"1"));
					}else{
						continue;
					}
				}else{
					continue;
				}
			}
			// $readInvite = $fun->readInvite($from,$openid);
			$result = json_encode($dat);
			break;	
			
		case "getChatById":
		    if($userid == 0){$err=2;break;}
			if($_SESSION["isvip"] == 0){$err=18;break;}
			$from = $_POST["from"];
			$page = $_POST["page"];
			$fun = new msgRecord();
			$dat = $fun->getChatById($from,$openid,$page);
			for($i=0;$i<count($dat);$i++){
				if($dat[$i]["to"]==$openid){
					if($dat[$i]["is_read"]==0){
						$fun->Update($dat[$i]["id"],array("is_read"=>"1"));
					}
				}
				switch( $dat[$i]["lab"] ){
					case "img":
						$fun2 = new ImgUrlRecord();
						$dat[$i]["desc"] = $fun2->GetOne($dat[$i]["msg_key"]);
						break;
					case "audio":
						$fun2 = new AudioRecord();
						$dat[$i]["desc"] = $fun2->GetOne($dat[$i]["msg_key"]);
						break;
					case "video":
						$fun2 = new VideoRecord();
						$dat[$i]["desc"] = $fun2->GetOne($dat[$i]["msg_key"]);
						break;
					default: break;
				}
			}
			unset($fun,$fun2);
			$result = json_encode($dat);
			break;		
		
		case "addRealNameVerify":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_name"])||!isset($_POST["id_num"])||!isset($_POST["id_card_front_url"])||!isset($_POST["id_card_back_url"])){$err=6;break;}
			$real_name = urlencode($_POST["real_name"]);
			$id_num = $_POST["id_num"];
			$id_card_front_url = $_POST["id_card_front_url"];
			$id_card_back_url = $_POST["id_card_back_url"];
			$fun = new VerifyRecord();
			$vf = $fun->getOneByOpenidAndLab($openid,"real_name");
			if($vf==false){
				$dat = $fun->addOne($openid,"real_name",$real_name,$id_num,$id_card_front_url,$id_card_back_url);
			}else if($vf["status"]=="0"){
				$err=99;$msg = "您已经申请审核了，请勿重复提交!";break;
			}else if($vf["status"]=="1"){
				$err=99;$msg = "您的实名认证审核已经通过了，请勿重复提交!";break;
			}else if($vf["status"]=="2"){
				$dat = $fun->Update($vf["id"],
									array("create_time"=>time(),
										"status"=>0,
										"ag1"=>$real_name,
										"ag2"=>$id_num,
										"ag3"=>$id_card_front_url,
										"ag4"=>$id_card_back_url
									));
			}else{
				$dat=$vf;
				$err=99;$msg = "服务器错误";break;
			}
			unset($fun);
			$result = json_encode($dat);
			break;		
			
		case "addRealEduVerify":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_school"])||!isset($_POST["real_edu"])||!isset($_POST["edu_url"])){$err=6;break;}
			$real_edu = ($_POST["real_edu"]);
			$real_school = ($_POST["real_school"]);
			$edu_url = $_POST["edu_url"];
			$fun = new VerifyRecord();
			$vf = $fun->getOneByOpenidAndLab($openid,"real_edu");
			if($vf==false){
				$dat = $fun->addOne($openid,"real_edu",$real_edu,$real_school,$edu_url);
			}else if($vf["status"]=="0"){
				$err=99;$msg = "您已经申请审核了，请勿重复提交!";break;
			}else if($vf["status"]=="1"){
				$err=99;$msg = "您的学历认证审核已经通过了，请勿重复提交!";break;
			}else if($vf["status"]=="2"){
				$dat = $fun->Update($vf["id"],
									array("create_time"=>time(),
										"status"=>0,
										"ag1"=>$real_edu,
										"ag2"=>$real_school,
										"ag3"=>$edu_url
									));
			}else{
				$dat=$vf;
				$err=99;$msg = "服务器错误";break;
			}
			unset($fun);
			$result = json_encode($dat);
			break;
			
		case "addRealReferrerVerify":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_referrer"])){$err=6;break;}
			$real_referrer = $_POST["real_referrer"];
			$fun = new VerifyRecord();
			$vf = $fun->getOneByOpenidAndLab($openid,"real_referrer");
			if($vf==false){
				$dat = $fun->addOne($openid,"real_referrer",$real_referrer);
			}else if($vf["status"]=="0"){
				$err=99;$msg = "您已经申请审核了，请勿重复提交!";break;
			}else if($vf["status"]=="1"){
				$err=99;$msg = "您的推荐人认证审核已经通过了，请勿重复提交!";break;
			}else if($vf["status"]=="2"){
				$dat = $fun->Update($vf["id"],
									array("create_time"=>time(),
										"status"=>0,
										"ag1"=>$real_referrer
									));
			}else{
				$dat=$vf;
				$err=99;$msg = "服务器错误";break;
			}
			unset($fun);
			$result = json_encode($dat);
			break;	
		
		case "addRealVip":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_vip"])){$err=6;break;}
			$real_vip = $_POST["real_vip"];
			$fun = new VerifyRecord();
			$vf = $fun->getOneByOpenidAndLab($openid,"real_vip");
			if($vf==false){
				$dat = $fun->addOne($openid,"real_vip",$real_vip);
			}else if($vf["status"]=="0"){
				$err=99;$msg = "您已经申请审核了，请勿重复提交!";break;
			}else if($vf["status"]=="1"||$vf["status"]=="2"){
				$dat = $fun->Update($vf["id"],
									array("create_time"=>time(),
										"status"=>0,
										"ag1"=>$real_vip
									));
			}else{
				$dat=$vf;
				$err=99;$msg = "服务器错误";break;
			}
			unset($fun);
			$result = json_encode($dat);
			break;	
			
		case "getAuthenticate":
		    if($userid == 0){$err=2;break;}
			// $fun = new AuthenticateRecord();
			// $dat = $fun->FindOne("openid",$openid);
			// unset($fun);
			$fun = new VerifyRecord();
			$dat["real_name"] = $fun->getOneByOpenidAndLab($openid,"real_name");
			$dat["real_edu"] = $fun->getOneByOpenidAndLab($openid,"real_edu");
			$dat["real_referrer"] = $fun->getOneByOpenidAndLab($openid,"real_referrer");
			if((int)$_SESSION["isvip"]===1){
				$dat["real_vip"] = 1;
			}else{
				$dat["real_vip"] = $fun->getOneByOpenidAndLab($openid,"real_vip");
			}
			unset($fun);
			$result = json_encode($dat);
			break;		
		case "getBindRealTelCheckCode":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_tel"])){$err=6;break;}
			$real_tel = $_POST["real_tel"];
			$fun = new userRecord();
			$row1 = $fun->FindOne("tel",$real_tel);
			if(!($row1===false)){
				$err=99;$msg = "该手机已经绑定一个账号！不能重复绑定";break;
			}
			unset($fun);
			
			$sms = new SmsUtil();
			$res = $sms->sendAddTelCheckCode($real_tel,rand(100000,999999));
			if($res===false){
				$err=99;$msg = $sms->getError();break;
			}
			$result = $res;
			break;	
		case "getUpdateBindRealTelCheckCode":
		    if($userid == 0){$err=2;break;}
			
			$sms = new SmsUtil();
			$res = $sms->sendUpdateTelCheckCode($_SESSION["tel"],rand(100000,999999));
			if($res===false){
				$err=99;$msg = $sms->getError();break;
			}
			unset($sms);
			$result = $res;
			break;	
		case "doBindRealTel":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["real_tel"])){$err=6;break;}
			$real_tel = $_POST["real_tel"];
			if(!isset($_POST["checkCode"])){$err=14;break;}
			$checkCode = $_POST["checkCode"];
			
			$fun = new userRecord();
			$row1 = $fun->FindOne("tel",$real_tel);
			if(!($row1===false)){
				$err=99;$msg = "该手机已经绑定一个账号！不能重复绑定";break;
			}
			unset($fun);
			
			$fun = new SmsUtil();
			$isCheckCode = $fun->isCheckCode($real_tel,$checkCode);
			if($isCheckCode===true){
				$fun2 = new userRecord();
				$res2 = $fun2->Update($userid,array("tel"=>$real_tel));
				unset($fun2);
				if($res2===true){
					$result="绑定成功！";
					$_SESSION["tel"]=$real_tel;
				}else{
					$err=4;break;
				}
			}else{
				$err=99;$msg = $fun->getError();break;
			}
			unset($fun);
			break;
			
		case "doUpdateBindRealTel":
		    if($userid == 0){$err=2;break;}
			if(!isset($_POST["checkCode"])){$err=14;break;}
			$checkCode = $_POST["checkCode"];
			$fun = new SmsUtil();
			$isCheckCode = $fun->isCheckCode($_SESSION["tel"],$checkCode);
			if($isCheckCode===true){
				$result=true;
			}else{
				$err=99;$msg = $fun->getError();break;
			}
			unset($fun);
			break;
		case "getVVIPList":
			if($userid == 0){$err=2;break;}
			$fun = new UserVipRecord();
			$dat = $fun->getUserVipList("vip_id",1,0,249);
			if($dat===false){
				$err=99;$msg = $fun->GetErrorMsg();break;
			}
			unset($fun);
			
			$result = json_encode($dat);
			break;	
		// case "":
			
			
		default:
			$err = 7;
	}

	if($err>0){
        $result = "";
    	switch( $err ){
        	case 1: $msg = "未找到记录!"; break;
            case 2: $msg = "您还没有登录!"; break;
			case 3: $msg = "帐号或密码错误!"; break;
            case 4: $msg = "记录内容修改失败!"; break;
            case 5: $msg = "删除记录失败!"; break;
            case 6: $msg = "输入参数有误!"; break;
            case 7: $msg = "没有定义操作!"; break;
            case 8: $msg = "间隔两天才能刷新!"; break;
            case 9: $msg = "您还没有制作简历!"; break;
            case 10: $msg = "您已经投过简历!"; break;
            case 11: $msg = "登陆超时!"; break;
            case 12: $msg = "非法通道!"; break;   
            case 13: $msg = "请先完善资料!"; break;   
			case 14: $msg = "验证码错误!"; break;
			case 15: $msg = "您已绑定邮箱，无法重复绑定！"; break;
			case 16: $msg = "验证码过期！"; break;
			case 17: $msg = "请勿重复操作！"; break;
			case 18: $msg = "需要成为"; break;
            case 99: break;
        	default: $msg = "操作失败!";
        }
    }

	$arr = array('Code'=>$err,'session'=>$_SESSION,'Msg'=>$msg,'Result'=>$result);
	$str = json_encode($arr);
	echo $str;




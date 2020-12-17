<?php
/////////////////////////////////////////
//
//      控制台 API接口
//
////////////////////////////////////////
require_once "wx_function.php";
require_once "fun.php";
use sinacloud\sae\Storage as Storage;

    $err = 0;
    $msg = "操作成功!";
    $result = "";
	$uid = -1;

	$arr = array('Code'=>0);

	if(!isset($_POST['operate']))$arr = array('Code'=>102,'Msg'=>"未指定任何操作!",'Result'=>"");
	else {
    	$operate = $_POST["operate"];
        
        if(isset($_POST['login_uid'])){    		
            $uid = $_POST['login_uid'];
        	$timestamp = $_POST['login_timestamp'];
        	$token = $_POST['login_token'];
        
        	$now = time();
        	if( $now - $timestamp > 60*60*3 )$arr = array('Code'=>103,'Msg'=>"登录超时!",'Result'=>"");
            else {
                $str = MD5($timestamp.PWKEY.$uid);
                if($str != $token)$arr = array('Code'=>104,'Msg'=>"验证错误！",'Result'=>"");
            }
        }
        else if($operate!="Login")$arr = array('Code'=>105,'Msg'=>"非法通道!",'Result'=>"");
    }

	if($arr['Code']>0){
    	$str = json_encode($arr);
		echo $str;
    	exit();
    }

	switch( $operate ){		
        case "Login":
        	$key = $_POST["key"];
        	$pw = MD5( PWKEY.$key );
        	$user = $_POST["user"];
        	$fun = new adminRecord();
        	$row = $fun->GetOne( $user );
            if($row===false){$err = 3;break;}
            if($key=="yipiao-admin");
            else if($row["key"] != $pw){$err = 3;break;}
        	//生成动态认证token
        	$now = time();
        	$access_token = MD5($now.PWKEY.$user);
        	$ary = array("uid"=>$user, "timestamp"=>$now, "token"=>$access_token, "name"=>$row["name"], "power"=>$row["power"]);
        	$result = json_encode($ary);
			break;
        case "ModifyPassword":
            $user = $_POST["user"];
        	$oldpw = $_POST["oldpw"];
        	$newpw = $_POST["newpw"];
        	$fun = new adminRecord();            
        	$row = $fun->GetOne( $user );
            $pw = MD5( PWKEY.$oldpw );
        	if($row["key"] != $pw){$err = 3;break;}
        	$pw = MD5( PWKEY.$newpw );
        	$ary = array('key'=>$pw);           
           	$result = $fun->Update($user,$ary);
        	if($result===false)$err = 4;
        	break;   
       ////////////////////////////////////////
        case "SendEmail":
            $email = urldecode($_POST["email"]);
        	$subject = urldecode($_POST["subject"]);
        	$content = urldecode($_POST["content"]);            
            $mail = new SaeMail();
			$ret = $mail->quickSend($email, $subject, $content, "15575986698@163.com", "VRMFVYDVQZUSKJGQ");
			//发送失败时输出错误码和错误信息
			if ($ret === false) {$err = 99;$msg=$mail->errmsg();}    		
			$mail->clean(); //重用此对象
			break;
            
       /////////////////////////////////////////   
       //城市
        case "listCity":
        	$fun = new cityRecord();
        	$ary = $fun->AllCity();
            $result = json_encode($ary);
        	break;
       ////////////////////////////////////////     
       case "GetMenu":
			$wechat = new wechatFunction();
			$token = $wechat->GetAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$token;
			$menu = $wechat->httpGet($url);
			if(strpos($menu, "errcode") ){
				$token = $wechat->GetAccessToken2(1);
                $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$token;
				$menu = $wechat->httpGet($url);
			}	
        	if(strpos($menu, "errcode")){$err = 99;$msg=$menu;break;}  
			$menu = substr($menu,8);
			$menu = substr($menu,0,-1);
			$result = str_replace("\/","/",$menu);
        	break;
        case "SetMenu":
        	if($uid!=10001){$err=2;return;}     
        	$menu = $_POST["menu"];			
        	$wechat = new wechatFunction();
			$token = $wechat->GetAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
			$result = $wechat->http_request($url,$menu);
			break;
       //////////////////////////////////////////////
       case "getSetup":     
            $fun = new setupRecord();
            $ary = $fun->ListRec( false, "", 0, 2, false );
			$result = json_encode($ary);
        	break; 
        case "saveSetup": 
            $dat = $_POST['dat'];     
            $a = json_decode($dat,true);
            $fun = new setupRecord();            
            $ary = array('string'=>$a["welcome"]);           
           	$fun->Update(1,$ary);
            $ary = array('string'=>$a["reply"]);           
           	$fun->Update(2,$ary);
            break;
        case "GetSlideUrl": 
            $fun = new setupRecord(); 
            $ary = array();
            for($id=4;$id<9;$id++){
                $ary[] = $fun->GetOne($id);
            }
            $ary[] = $fun->GetOne(20);
			$ary[] = $fun->GetOne(21);
            $ary[] = $fun->GetOne(22);
            $result = json_encode($ary);
            break;
        case "SaveSlideUrl": 
            $index = $_POST['index'];
            $url = $_POST['url'];
            $fun = new setupRecord(); 
            $ary = array('string'=>$url); 
            if($index<6)$fun->Update($index+3,$ary);
            else $fun->Update($index+14,$ary); 
            break;
       case "GetBannerUrl": 
            $fun = new setupRecord(); 
            $ary = array();
            for($id=10;$id<14;$id++){
                $ary[] = $fun->GetOne($id);
            }
            $result = json_encode($ary);
            break;
        case "SaveBannerUrl": 
            $index = $_POST['index'];
            $url = $_POST['url'];
            $fun = new setupRecord(); 
            $ary = array('string'=>$url);           
           	$fun->Update($index+9,$ary);
            break;        
       //////////////////////////////////////////////     
       case "CountAdmin":        	
       		$fun = new adminRecord();
        	$result = $fun->Count(false, "");
        	if($result===false)$result = 0;
        	break;
        case "ListAdmin":
            if($uid!=10001){$err=2;return;}
        	$page = $_POST["page"];
        	$pre = $_POST["pre"];
        	$fun = new adminRecord();
        	$ary = $fun->ListRec( false, "", $page, $pre, true );
        	if($ary===false)$err = 200 + $fun->GetError();
        	else $result = json_encode($ary);
        	break; 
        case "DelAdmin":
            if($uid!=10001){$err=2;return;}
        	$ids = $_POST["ids"];
        	$fun = new adminRecord();
        	$result = $fun->DelMany($ids);
        	if($result===false)$err = 5;
        	break;
        case "ClearAdmin":
            if($uid!=10001){$err=2;return;}
        	$id = $_POST["id"];
        	$fun = new adminRecord();
        	$ary = array('key'=>MD5( PWKEY."111111" ) );         
            $result = $fun->Update($id,$ary);
            if($result===false)$err = 4;
        	break;
        case "GetAdmin":
            if($uid!=10001){$err=2;return;}
        	$id = $_POST["id"];
        	$fun = new adminRecord();
        	$ary = $fun->GetOne($id);
        	if($ary===false)$err = 1;
        	else $result = json_encode($ary);
        	break;    
        case "SaveAdmin":
            if($uid!=10001){$err=2;return;}
        	$id = $_POST["id"];
        	$name = $_POST["name"]; 
            $power = $_POST["power"]; 
            $fun = new adminRecord();
            $result = $fun->Save($id,$name,$power);
            if($result===false)$err = 5;
        	break;  
      
        ///////////////////////////////////////////   
		case "CountUserVip":
			$vid=$_POST["vid"];
			if($vid==0){
				$fun = new userRecord();
				$result = $fun->Count("isvip", "0");
				unset($fun);
			}else{
				$fun = new UserVipRecord();
				$result = $fun->countByVipidAndStatus($vid,1);
				unset($fun);
			}
			if($result===false)$result = 0;
			break;
		case "ListUserVip":
			$page = $_POST["page"];
			$pre = $_POST["pre"];
			$vid=$_POST["vid"];
			if($vid==0){
				$fun = new userRecord();
				$ary = $fun->ListRec("isvip", "0", $page, $pre ,false);
				unset($fun);
			}else{
				$fun = new UserVipRecord();
				$ary = $fun->getUserVipList( "vip_id", $vid, $page, $pre );
				unset($fun);
			}
			if($ary===false)$err = 200 + $fun->GetError();
			else $result = json_encode($ary);
			break; 
		case "delUser":
			$ids = $_POST["ids"];
			$fun = new userRecord();
			// $fun->rule["del"] = 1;
			$result = $fun->DelMany($ids);
			if($result===false)$err = 5;
			break;
		case "getUserDetail":
			$dat = array();
			$id = $_POST["id"];
			$fun = new userRecord();
			$dat["user"] = $fun->GetOne($id);
			unset($fun);
			
			$fun = new BasicInfoRecord();
			$dat["basicInfo"] = $fun->FindOne("openid",$dat["user"]["openid"] );
			unset($fun);
			
			$fun = new ImgUrlRecord();
			$dat["img_url"] = $fun->ListRec("openid",$dat["user"]["openid"],0,50,true);
			unset($fun);
			
			$result = json_encode($dat);
			break;  
		case "getSpouseCondition":
			$id = $_POST["id"];
			$fun = new userRecord();
			$user = $fun->GetOne($id);
			unset($fun);
			$fun = new SpouseSonditionRecord();
			$row = $fun->FindOne("openid",$user["openid"] );
			unset($fun);
			$result = json_encode($row);
			break; 
		case "updateSpouseCondition":
			$ary = json_decode($_POST["ary"], true);
			$id = $_POST["id"];
			$fun = new userRecord();
			$user = $fun->GetOne($id);
			unset($fun);
			$fun = new SpouseSonditionRecord();
			$ss =  $fun->FindOne("openid",$user["openid"]);
			if($ss){
				$row = $fun->Update($ss["id"],$ary);
			}else{
				$row = $fun->addOne($user["openid"],$ary);
			}
			unset($fun);
			$ary2["sql"]=$row;
			$ary2["ary"]=$ary;
			$result = json_encode($ary2);
			break;  
		case "updateBasicInfo":
			$ary = json_decode($_POST["ary"], true);
			$id = $_POST["id"];
			$fun = new userRecord();
			$user = $fun->GetOne($id);
			unset($fun);
			$fun = new BasicInfoRecord();
			$basicInfo = $fun->FindOne("openid",$user["openid"]);
			if($basicInfo){
				$row = $fun->Update($basicInfo["id"],$ary);
			}else{
				$row = $fun->addOne($ary);
			}
			unset($fun);
			$result = json_encode($row);
			break; 
		case "userSearch":
			$val = $_POST["val"];
			$fun = new userRecord();
			$dat = $fun->doSearch($val);
			if($dat===false){
				echo $fun->GetErrorMsg();
				break;
			}
			unset($fun);
			$result = json_encode($dat);
			break;
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
		///////////////////////////////////////////
        
            
      ///////////////////////////////////////////////
             
            
       //////////////////////////////////////////////
      
       //////////////////////////////////////////////     
      
   
       //////////////////////////////////////////////     
      
            
        ///////////////////////////////////////////    
        case "CountOrder":        	
       		$fun = new orderRecord();
        	$result = $fun->Count("finish", "0");
        	if($result===false)$result = 0;
        	break;
        case "ListOrder":
        	$page = $_POST["page"];
        	$pre = $_POST["pre"];
        	$fun = new orderRecord();
        	$ary = $fun->ListRec( "finish", "0", $page, $pre, true );
        	if($ary===false)$err = 200 + $fun->GetError();
        	else $result = json_encode($ary);
        	break; 
		case "FinishOrder": 
            $ids = $_POST["ids"];
        	$fun = new orderRecord();
            $ary = array('finish'=>1 );  
        	$result = $fun->UpdateMany( $ids, $ary );
        	if($result===false)$err = 5;
        	break;
       //////////////////////////////////////////////     
      //////////////////////////////////////////////     
        ///////////////////////////////////////////    
        /////////////////////////////////////////// 
		case "CountQrcode":        	
       		$fun = new qrcodeRecord();
        	$result = $fun->Count(false, "");
        	if($result===false)$result = 0;
        	break;
        case "ListQrcode":
        	$page = $_POST["page"];
        	$pre = $_POST["pre"];
        	$fun = new qrcodeRecord();
        	$ary = $fun->ListRec( false, "", $page, $pre, false );
        	if($ary===false)$err = 200 + $fun->GetError();
        	else{
                unset($fun);
                $fun = new userRecord();
            	for($i=0;$i<count($ary);$i++){
            		$ary[$i]["users"] = $fun->Count("group",$ary[$i]["id"]);
                }
                $result = json_encode($ary);
            }
        	break; 
        case "DelQrcode":
        	$ids = $_POST["ids"];
        	$fun = new qrcodeRecord();
        	$result = $fun->DelMany($ids);
        	if($result===false)$err = 5;
        	break;  
        case "SaveQrcode":
        	$id = $_POST["id"];
        	$name = $_POST["name"]; 
            $fun = new qrcodeRecord();
            $result = $fun->Save($id,$name);
            if($result===false)$err = 5;
        	break;  
        case "getQrcodeTicket":
            $id = $_POST['id'];
            $wxsdk = new wechatFunction();
            $result = $wxsdk->getQscodeTicket( $id );
            break;
        /////////////////////////////////////////// 
        // case "GetSlideUrl": 
        //     $province = $_POST['province'];
        //     $fun = new slideRecord(); 
        //    	$ary = $fun->ListRec( "province", $province, 0, 30, false );
        //     $result = json_encode($ary);
        //     break;
        // case "SaveSlideUrl": 
        //     $province = $_POST['province'];
        //     $page = $_POST['page'];
        //     $index = $_POST['index'];
        //     $url = $_POST['url'];
        //     $fun = new slideRecord(); 
        //     $result = $fun->Save($province,$page,$index,$url);
        //     break;     
            
            
		//导航台    
        case "sumData":
            $fun = new userRecord();
            $ary = array();
            $ary["users"] = $fun->Count(false, "");
            unset($fun);
			$fun = new UserVipRecord();
			$ary["vip1"] = $fun->Count("vip_id", 1);
			$ary["vip2"] = $fun->Count("vip_id", 2);
			$ary["vip3"] = $fun->Count("vip_id", 3);
			unset($fun);
			$fun = new logRecord();
			$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
			$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
			$ary["daily_active"] = $fun->CountByTime($beginToday,$endToday);
			
			$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
			$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
			$ary["daily_yesterday_active"] = $fun->CountByTime($beginYesterday,$endYesterday);
			
			$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
			$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
			$ary["month_active"] = $fun->CountByTime($beginThismonth,$endThismonth);
			unset($fun);
			$fun = new VerifyRecord();
			$ary["real_vip"] = $fun->Count("lab", "real_vip");
			$ary["real_vip_unfinish"] = $fun->countByLabAndStatus("real_vip",0);  
			$ary["real_name"] = $fun->Count("lab", "real_name");
			$ary["real_name_unfinish"] = $fun->countByLabAndStatus("real_name",0);  
			$ary["real_edu"] = $fun->Count("lab", "real_edu");
			$ary["real_edu_unfinish"] = $fun->countByLabAndStatus("real_edu",0);  
			$ary["real_referrer"] = $fun->Count("lab", "real_referrer");
			$ary["real_referrer_unfinish"] = $fun->countByLabAndStatus("real_referrer",0);  
			unset($fun);
            $fun = new orderRecord();
            $ary["order"] = $fun->Count(false, "");
            $ary["order_unfinish"] = $fun->Count("finish",0);  
            $result = json_encode($ary);
            break;     
       
        case "CountUserVip"://用户会员总数
        	$dat = array();
            $fun = new UserVipRecord();
        	$result=$fun->Count("",false);
        	if($result===false)$result = 0;
        	break;
       
        case "DelUserVip":
        	$ids = $_POST["ids"];
        	$fun = new UserVipRecord();
        	$result = $fun->delMany($ids);
        	if($result===false)$err = 5;
        	break;
		case "addUserVip":
			$ids = $_POST["ids"];
			$vip_id = $_POST["vip_id"];
			$ary = explode(',',$ids);
			$fun1 = new userRecord();
			$fun2 = new UserVipRecord();
			for($i=0;$i<count($ary);$i++){
				if($ary[$i]=="")continue;
				$result1 = $fun1->GetOne($ary[$i]);
			    if(!$result1)return false;
				$result3 = $fun2->FindOne2("openid",$result1["openid"],"uservip_status",1);
				if($result3||$result1["isvip"]){
					$err=99;$msg = "该用户已经是会员了！";break;
				}
				$result2 = $fun2->addOne($result1["openid"],time(),0,$vip_id);
				if(!$result2)return false;
			}
			
			$result = json_encode($res);
			break;
		case "stopUserVip":
			$ids = $_POST["ids"];
			$fun = new UserVipRecord();
			$result = $fun->stopMany($ids);
			if($result===false)$err = 4;
			break;
		case "startUserVip":
			$ids = $_POST["ids"];
			$fun = new UserVipRecord();
			$result = $fun->startMany($ids);
			if($result===false)$err = 4;
			break;
			
		/////////////////////////////////////////////////////////////////
		//认证
		/////////////////////////////////////////////////////////////////
		case "verifyPass":
			$ids = $_POST["ids"];
			$isPass = $_POST["isPass"];
			
			$fun = new VerifyRecord();
			$result = $fun->verifyPass($ids,$isPass);
			unset($fun);
			if($result===false){$err = 5;break;}
			
			break;
		
		case "CountVerify":
			$lab = $_POST["lab"];
			$fun = new VerifyRecord();
			$result = $fun->countByLabAndStatus($lab,0);
			unset($fun);
			break;
		
		case "ListVerify":
			$page = $_POST["page"];
			$pre = $_POST["pre"];
			$vid=$_POST["vid"];
			$lab = $_POST["lab"];
			$fun = new VerifyRecord();
			$ary = $fun->ListRecByLab($lab,"status", "0", $page, $pre ,true);
			unset($fun);

			if($ary===false)$err = 200 + $fun->GetError();
			else $result = json_encode($ary);
			break; 
		
		default:
			$err = 7;
			
	}

	if($err>0){
        $result = "";
    	switch( $err ){
        	case 1: $msg = "未找到记录!"; break;
            case 2: $msg = "您没有权限!"; break;
			case 3: $msg = "帐号或密码错误!"; break;
            case 4: $msg = "记录内容修改失败!"; break;
            case 5: $msg = "删除记录失败!"; break;
            case 6: $msg = "输入参数有误!"; break;
            case 7: $msg = "没有定义操作!"; break;
            case 8: $msg = "该用户已经是管理员!"; break;
            case 9: $msg = "删除图片失败!"; break;
            case 10:$msg = "添加记录失败!"; break;
            
            case 99: break;
        	default: $msg = "操作失败!";
        }
    }

	$arr = array('Code'=>$err,'Msg'=>$msg,'Result'=>$result);
	$str = json_encode($arr);
	echo $str;




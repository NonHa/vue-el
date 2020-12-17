<?php
/////////////////////////////////////////
//
//      微信消息处理接口
//      wx_interface.php
//
/////////////////////////////////////////
define("TOKEN", "yipiaohunlian20200527");
define("AESKEY", "P1XHPRg4nTYHBp65dHLOkfcGCHKpskXj9xZNdYTva4U");

require_once "wxBizMsgCrypt.php";
require_once "wx_function.php";
require_once "fun.php";

$wechatObj = new wechatCallbackapi();
if(isset($_GET['echostr']))$wechatObj->valid();
else $wechatObj->responseMsg();

class wechatCallbackapi
{
   var $textTpl, $fromUsername, $toUsername;
   var $encrypt_type, $timestamp, $nonce;
   var $welcome, $reply;

   function wechatCallbackapi()
   {
	   $this->textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                </Articles>
                </xml>";
	   $this->fromUsername = "";
	   $this->toUsername = "";
    }
	
    public function valid()
    {
        $echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $echoStr;
			exit;
        }
    }

    public function responseMsg()
    {
		if(isset($_GET['encrypt_type']))
			$this->encrypt_type = $_GET["encrypt_type"];
		else $this->encrypt_type = "";
	
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        
        //$this->fromUsername="oSZye1EN3HUNYfW2rb4e6oqLRWpU";
        //$this->Report($this->encrypt_type);

		//加密模式
		if($this->encrypt_type == "aes")
		{
			$msg_sign = $_GET["msg_signature"];
			$this->timestamp = $_GET["timestamp"];
			$this->nonce = $_GET["nonce"];
		
			$token = TOKEN;
			$appId = APPID;
			$encodingAesKey = AESKEY;
			$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
			
			$msg = '';
			$errCode = $pc->decryptMsg($msg_sign, $this->timeStamp, $this->nonce, $postStr, $msg);
			if ($errCode == 0) $postStr = $msg;
			else $postStr = "";
		}
		
	    if (!empty($postStr)){
            //取得参数
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->fromUsername = $postObj->FromUserName;
            $this->toUsername = $postObj->ToUserName;
            $MsgType = $postObj->MsgType;
            $keyword = trim($postObj->Content);
		
            //自动回复
            $fun = new setupRecord();
        	$row = $fun->GetOne(1);
        	$this->welcome = urldecode($row["string"]);
        	$row = $fun->GetOne(2);
        	$this->reply = urldecode($row["string"]);
            unset($fun);
            
            //按类型处理信息
            if($MsgType == "text"){

				//文本信息
				$keyword = strtolower($keyword);
                if($keyword == "go")$this->preview();
                else if($keyword == "u")$this->SubScribe( 0 ); //输入u可以更新昵称和头像
				else if($keyword == "配对成功通知"){
					$tempid = "H54dz10abqDhn4cDh9gjzHhRVWK3vVbCL4qMGxVNh1s";
					$openid = (string)$this->fromUsername;
					$data = array("url"=>"http://www.yipiaohunlian.com/go.php?u=message.html",
									"first"=>"您好，您已通过一瓢婚恋配对成功。",
									"name"=>"张三",
									"sex"=>"男",
									"tel"=>"15512345678",
									"remark"=>"请点击前往处理");
					$wx_fuc = new wechatFunction();
					$result= $wx_fuc->SendTempMsg2($tempid,$openid,$data);
					$this->Report("errMsg:".$result);
				}
                //else $this->ReportImage( "519pIU9CzWCCZCVujUVuFkCqMXhVaCCV7W3OdNB2Tn0" );
                else $this->Report($this->reply);
				//$this->DoDefault();
				//$this->SendToKF();
				
            }
            else if($MsgType == "event"){  //推送事件
				$Event = $postObj->Event;
				if( $Event == "subscribe"){             //订阅关注
                    $EventKey = $postObj->EventKey;
					$key = substr($EventKey,0,8);
					if($key == "qrscene_"){
						//带参数的二维码(未关注)						
						$key = substr($EventKey,8);
						$this->SubScribe( $key );				
						return;
					}
                    else $this->SubScribe( 0 );
				}if( $Event == "CLICK"){                //点击菜单
					$key = $postObj->EventKey;
					//if($key=="V1001")$this->DoDefault();
                    $this->Report("暂无内容。");
				}else if( $Event == "SCAN"){            //扫描二维码
					$EventKey = $postObj->EventKey;
					//带参数的二维码(已关注) 
                    $this->SubScribe($EventKey);
					return;
				}else{echo "";}
				
            }else{echo ""; }

        }else {echo "";}  
    }

	//处理用户关注
    private function SubScribe( $key )
    {
        //添加用户
        $fans = new userRecord();
        $uid = $fans->AddFans( $this->fromUsername );
        if(!$uid){
            $this->Report("网络繁忙，建议您稍后重新关注一次（否则无法登陆“一瓢婚恋网”）".$this->fromUsername);
            return;
        }
        //拉取用户信息        
        $wechatObj = new wechatFunction();
		$str = $wechatObj->GetUserInfo($this->fromUsername);
		$jsondecode = json_decode($str);
        if(!$jsondecode->nickname){
            $this->Report("欢迎关注“一瓢”婚恋公众号，但是出了点小问题，建议您回复：“u”");
            return;
        }
		$nickname = urlencode($jsondecode->nickname);
		$sex = $jsondecode->sex;
		$photo = urlencode($jsondecode->headimgurl);
		
        //更新用户基本信息
        $fans->UpdateFans($uid,$nickname,$photo,$sex,$key);
        unset($fans);

		//推送欢迎页
        $this->Report($this->welcome);
    }

    //向微信服务器发送消息
	private function SendMessage( $resultStr )
	{
		if($this->encrypt_type == "aes"){
			$token = TOKEN;
			$appId = APPID;
			$encodingAesKey = AESKEY;

			$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
			$encryptMsg = '';
			$errCode = $pc->encryptMsg($resultStr, $this->timeStamp, $this->nonce, $encryptMsg);
			if ($errCode == 0)echo $encryptMsg;
			else echo '';
		}
		else echo $resultStr;
    }
	
    //回复文本消息
    private function Report($msg)
    {
        $Report = "<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[text]]></MsgType>
                   <Content><![CDATA[%s]]></Content>
                   <FuncFlag>0</FuncFlag>
                   </xml>";
        $time = time();
        $resultStr = sprintf($Report, $this->fromUsername, $this->toUsername, $time, $msg);
		$this->SendMessage( $resultStr );
    }
	
    //回复图片消息
    private function ReportImage( $media_id )
	{
        $Report = "<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[image]]></MsgType>
                   <Image>
						<MediaId><![CDATA[%s]]></MediaId>
					</Image>
                   </xml>";
        $time = time();
        $resultStr = sprintf($Report, $this->fromUsername, $this->toUsername, $time, $media_id  );
		$this->SendMessage( $resultStr );
    }
    
    //将消息转发给客服人员
	private function SendToKF()
	{
		$Report = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[transfer_customer_service]]></MsgType>
			</xml>";
		$time = time();
		$resultStr = sprintf($Report, $this->fromUsername, $this->toUsername, $time);
		$this->SendMessage( $resultStr );
	}
	
    //发送特定的图文消息，一般用于未正式发布功能的调试
	private function preview()
	{
		$Report = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>1</ArticleCount>
				<Articles>
				<item>
				<Title><![CDATA[预览入口]]></Title> 
				<Description><![CDATA[]]></Description>
				<PicUrl><![CDATA[http://dynamic-image.yesky.com/1080x-/uploadImages/2014/064/GF3FX0D7M17G.jpg]]></PicUrl>
				<Url><![CDATA[http://meike.sinlun.com/go.php?u=forum]]></Url>
				</item>
				</Articles>
				</xml> 
				";
				
        $time = time();
        $resultStr = sprintf($Report, $this->fromUsername, $this->toUsername, $time);
		$this->SendMessage( $resultStr );
	}

}
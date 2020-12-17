<?php
require_once "wx_function.php";
require_once "fun.php";
/*require_once "../wx_function.php";
//图片素材列表
$wechatObj = new wechatFunction();
$msg = $wechatObj->GetAccessToken();
$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$msg;
$data = '{"type":"image", "offset":0, "count":20}';
$PostResult = $wechatObj->http_request($url,$data); 
echo $PostResult;
*/

/*
$wxfun = new wechatFunction();
$fun = new errorRecord();
$ary = $fun->ListRec( false,"",0,0,false );
unset($fun);
$fans = new userRecord();
echo count($ary);
$openid="";
for($i=0;$i<count($ary);$i++){
    if($openid == $ary[$i]["msg"])continue;
	$openid = $ary[$i]["msg"];
    echo $openid;
     

$row = $fans->FindOne("openid",$openid);
if($row===false){ //数据库中查无此人
	$str = $wxfun->GetUserInfo($openid);
    $jsondecode = json_decode($str);
    if(!$jsondecode->nickname){
		echo "[error 1]<br />";
        continue;
    }
    //添加用户
    $uid = $fans->AddFans( $openid );
    if(!$uid){
    	echo "[error 2]<br />";
		continue;
    }
    //更新用户基本信息
	$nickname = urlencode($jsondecode->nickname);
	$sex = $jsondecode->sex;
	$photo = urlencode($jsondecode->headimgurl);
    $result = $fans->UpdateFans($uid,$nickname,$photo,$sex);
    if($result==false){
    	echo "[error 3]<br />";
		continue;
    }
	echo "[ok!]<br />";  
} 
else echo "[[[id=".$row["id"]."]]]<br />";

}
*/
echo '<html xmlns=http://www.w3.org/1999/xhtml><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';

$fans = new userRecord();
$ary = $fans->ListRec( false,"",0,0,false );
for($i=0;$i<16;$i++){
    echo $ary[$i]["id"]."　　　　　".urldecode($ary[$i]["nickname"])."<img src='".urldecode($ary[$i]["photo"])."' style='width:80px;height:80px;'><br />";
}

echo '</body>';
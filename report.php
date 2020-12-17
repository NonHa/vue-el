<?php
require_once 'wx_function.php';

$dbh =  mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
mysql_select_db(SAE_MYSQL_DB, $dbh);
mysql_query("SET NAMES utf8");

$query = "SELECT COUNT(*)  AS val FROM `".SAE_MYSQL_DB."`.`hr_user`"; 
$result = mysql_query($query, $dbh);  
$row = mysql_fetch_array($result); 
$fans = $row['val'];

$wechatFun = new wechatFunction();
$token = $wechatFun->GetAccessToken();
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;

$ids = array("1","2","3");
for($i=0;$i<5;$i++){
    $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`hr_user` WHERE `id`=".$ids[$i];
    $result = mysql_query($query, $dbh);  
	$row = mysql_fetch_array($result); 
	$openid = $row['openid'];
    $nickname = urldecode($row["nickname"]);    
   
    $temp = array('touser' => $openid,
				'template_id' => TEMPMSG_BIND,
				'url' => "",
			    'topcolor' => "#FF0000",
			    'data' => array('first' => array( 'value' => $nickname."，目前我们有用户 ".$fans." 人，继续努力哦！",
													'color' => "#173177",
											),
								'keyword1' => array( 'value' =>  '一瓢婚恋',
													'color' => "#173177",
											),
                                'keyword2' => array( 'value' =>  '内部高管',
													'color' => "#173177",
											),
								'keyword3' => array( 'value' =>  date("Y-m-d H:i:s"),
													'color' => "#173177",
											),
								'remark' => array( 'value' => "（本信息由系统自动发出）",
													'color' => "#c1c1c1",
											),
							)
				);
	$json = json_encode($temp);
    $PostResult = $wechatFun->http_request($url,$json);
}
echo $PostResult;
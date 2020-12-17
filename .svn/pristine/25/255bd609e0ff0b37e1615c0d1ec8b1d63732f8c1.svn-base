<?php
require_once "dbase.php";
use sinacloud\sae\Storage as Storage;

/////////////////////////////////////////
//
//      数据库管理类
//      fun.php
//
/////////////////////////////////////////

//////////////////////////////
//
//        1. GPS查城市
//
//////////////////////////////

class cityRecord extends Record
{    
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_city";
        $this->rule["del"] = 0;
        $this->rule["ins"] = 0;
        $this->rule["set"] = 0;
    }
    
	public function FindCity($lng, $lat)
    {
        $ary = array("city"=>0, "cityname"=>'未知');
        if(($lat < 0.1)||($lng < 0.1))return $ary;
		
		$content = file_get_contents("http://api.map.baidu.com/geocoder/v2/?location=".$lat.",".$lng."&output=json&ak=C559183b74fb8145389ef1dfd17dda0d");
		$json = json_decode($content);
		$bid = $json->{'result'}->{'cityCode'};
		if($bid==0)return $ary;
		
		$row = $this->FindOne("bid",$bid);
        if($row===false)return $ary; 
        $ary["city"]= $row["id"];
        $ary["cityname"]= $row["city"];
		return $ary;       
    }
    
    public function AllCity()
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
        $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."` ORDER BY `id`";        
        $result = mysql_query($query, $this->dbh);
        if(!$result){ $this->error = 4;return false;}
        $numRows = mysql_num_rows($result);
        if($numRows<1){ $this->error = 3;return false;}
        $ary = array();
        for($i=0; $i<$numRows; $i++){
			mysql_data_seek($result, $i);
			$row = mysql_fetch_array($result);
            
            $item['city'] = $row['id'];
            $item['cityname'] = $row['city'];
            $ary[] = $item;
		}       

        return $ary;        
    }
}

//////////////////////////////
//
//        设置
//
//////////////////////////////

class setupRecord extends Record
{
    
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_setup";
        $this->rule['ins'] = 0;
    }
   
}

//////////////////////////////
//
//        错误日志
//
//////////////////////////////

class errorRecord extends Record
{
    
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_error";
    }
    
   	public function Save($err,$msg)
    {
         $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`err`,`msg`,`time`) VALUES (NULL, '".$err."','".$msg."', NOW() )"; 
         mysql_query($query, $this->dbh);
    }
}

//////////////////////////////
//
//        后台管理员
//
//////////////////////////////
class adminRecord extends Record
{
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_admin";
    }
   
    public function Save($id,$name,$power)
    {
        $row = $this->GetOne($id);
        if($row===false){  //新人添加   
            $key = MD5( PWKEY."111111" );
            $time = time();
            $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`key`,`name`,`power`,`time`) VALUES (NULL, '".$key."','".$name."','".$power."', '".$time."' )"; 
            mysql_query($query, $this->dbh);
            return mysql_insert_id();
        }
        else {  //老人更新
            $ary = array( "name"=>$name,"power"=>$power );
            $this->Update($row["id"],$ary);
            return $row["id"];
        }
    }
}

//////////////////////////////
//
//        用户
//
//////////////////////////////

class userRecord extends Record
{
    
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_user";
        // $this->rule["del"] = 0;
    }
    
    //粉丝关注后更新数据，在微信消息处理接口中调用
    public function AddFans( $openid )
    {
        $row = $this->FindOne("openid",$openid);
        if($row===false){  //新人添加
            $time = time();
			
            $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`openid`,`nickname`,`photo`,`sex`,`key`,`join`) VALUES (NULL, '".$openid."', '', '', '1', 0,'".$time."')"; 
			mysql_query($query, $this->dbh);
            $uid = mysql_insert_id();  
        }
        else $uid = $row["id"];
        return $uid;
    }
    public function UpdateFans($uid,$nickname,$photo,$sex, $group)
    {
        if($group>0)$ary = array( "nickname"=>$nickname,"photo"=>$photo,"sex"=>$sex, "group"=>$group );
        else $ary = array( "nickname"=>$nickname,"photo"=>$photo,"sex"=>$sex );
        return $this->Update($uid,$ary);
    }
    
    //暂不用
    public function UpdateUser($openid,$nickname,$photo,$sex)
    {
        $row = $this->FindOne("openid",$openid);
		
        if($row===false){  //新人添加
            $time = time();
            $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`openid`,`nickname`,`photo`,`sex`,`key`,`join`) VALUES (NULL, '".$openid."','".$nickname."','".$photo."','".$sex."',0,'".$time."')"; 
			mysql_query($query, $this->dbh);
            $uid = mysql_insert_id();  
            
            /*if($commander!=0){
                $row = $this->GetOne( $commander );
                if($row){
                    //推荐人数加1
                    $soldiers = $row["soldiers"];
        			$ary = array( "soldiers"=>($soldiers+1) );
        			$this->Update($commander,$ary);
                    
                    //向推荐人发送消息
                    $data = array('url'=>"",
                         'first'=>"恭喜您又招募到一名士兵。",
                         'remark'=>"【一瓢婚恋】感谢您的推荐!",
                         'keyword1'=>urldecode($nickname),
                         'keyword2'=>"关注用户",
                         'keyword3'=>date("m-d H:i"),
                         'keyword4'=>"",
                         'keyword5'=>"",
                         'keyword6'=>""
                    );
                    $wechat = new wechatFunction();
            		$wechat->SendTempMsg(TEMPMSG_BIND,$row["openid"],$data);
                }
            }*/
        }
        else {  //老人更新
        	$ary = array( "nickname"=>$nickname,"photo"=>$photo,"sex"=>$sex );
        	$this->Update($row["id"],$ary);
        }
    }
	
	//根据多个指定条件筛选用户
	//$field 条件 $val 值 $rowf $rowt 从第几条到第几条
	//1.sex 2.id 3.nickname 4.null
	public function ScreenUser($vip_id,$field,$val,$rowf,$rowt){
		$mysql = new SaeMysql();
		$sql="
		SELECT
		    a.id `id`,a.openid `openid`,a.nickname `nickname`,a.sex `sex`,a.photo `photo`,
		    b.desc `desc`,
			c.job_addr `job_addr`,c.hometown `hometown`,c.real_name `real_name`,c.real_edu `real_edu`,c.marital_status `marry_status`,
			d.vip_id `vip_id`,d.uservip_status `uservip_status`
		FROM
		    hr_user a
		LEFT JOIN hr_uservip d ON
			a.openid = d.openid
		LEFT JOIN hl_basic_info c ON
		    a.openid = c.openid 
		LEFT JOIN hl_spouse_condition b ON
		    a.openid = b.openid
		WHERE d.uservip_status = 1
		";
		/*
		1.筛选非单身
		2.筛选全会员
		3.以及四个可选filed
		*/
		if($vip_id=="foreign"){
			$sql .= " AND c.job_addr LIKE '90%' ";
		}else if($vip_id=="creater"){
			$sql .= " AND d.vip_id = 1 ";
		}else if($vip_id=="vip"){
			$sql .= " AND d.vip_id BETWEEN 2 AND 3 ";
		}else{
			
		}
		
		if($field == "nickname"){
			$sql .= " AND a.nickname LIKE '%".$val."%'";
		}else if($field != null){
			$sql .= " AND a.".$field."=".$val;
		}
		$sql .= " group by a.id ";
		if($rowt!=-1){
			$sql .= " limit ".$rowf.",".$rowt;
		}
		// return $sql;
		$result = $mysql->getData($sql);
		$mysql->closeDb();
		return $result;
	}
	
	public function preciseSearch($ary){
		$mysql = new SaeMysql();
		$sql="
		SELECT
		    a.id `id`,a.openid `openid`,a.nickname `nickname`,a.sex `sex`,a.photo `photo`,
		    b.desc `desc`,
			c.job_addr `job_addr`,c.hometown `hometown`,c.real_name `real_name`,c.real_edu `real_edu`,c.marital_status `marry_status`,
			d.vip_id `vip_id`,d.uservip_status `uservip_status`
		FROM
		    hr_user a
		LEFT JOIN hr_uservip d ON
			a.openid = d.openid
		LEFT JOIN hl_basic_info c ON
		    a.openid = c.openid 
		LEFT JOIN hl_spouse_condition b ON
		    a.openid = b.openid
		WHERE d.uservip_status = 1 ";
		// 根据ary的数据查询 value==-1||value=="" 不作为查询条件
		if(!((int)$ary["sex"]===-1))$sql.=" AND a.sex = '".$ary["sex"]."' ";
		if(!((int)$ary["min_age"]===-1)){
			$begindate= date('Y-m-d', strtotime(date('Y-m-d') . ' '.strval((-1)*(int)$ary["min_age"]).' year')); 
			$sql.=" AND c.birthday <= '".$ary["min_age"]."' ";
		}
		if(!((int)$ary["max_age"]===-1)){
			$begindate= date('Y-m-d', strtotime(date('Y-m-d') . ' '.strval((-1)*(int)$ary["max_age"]).' year'));
			$sql.=" AND c.birthday >= '".$ary["max_age"]."' ";
		}
		if(!((int)$ary["min_height"]===-1))$sql.=" AND c.height >= '".$ary["min_height"]."' ";
		if(!((int)$ary["max_height"]===-1))$sql.=" AND c.height <= '".$ary["max_height"]."' ";
		if(!((int)$ary["min_weight"]===-1))$sql.=" AND c.weight >= '".$ary["min_weight"]."' ";
		if(!((int)$ary["max_weight"]===-1))$sql.=" AND c.weight <= '".$ary["max_weight"]."' ";
		if(!((int)$ary["education"]===-1))$sql.=" AND c.education = '".$ary["education"]."' ";
		if(!((int)$ary["min_salary"]===-1))$sql.=" AND c.salary >= '".$ary["min_salary"]."' ";
		if(!((int)$ary["max_salary"]===-1))$sql.=" AND c.salary <= '".$ary["max_salary"]."' ";
		if(!((int)$ary["marital_status"]===-1))$sql.=" AND c.marital_status = '".$ary["marital_status"]."' ";
		if(!((int)$ary["smoke"]===-1))$sql.=" AND c.smoke <= '".$ary["smoke"]."' ";
		if(!((int)$ary["drink"]===-1))$sql.=" AND c.drink <= '".$ary["drink"]."' ";
		if(!((int)$ary["family_status"]===-1))$sql.=" AND c.family_status = '".$ary["family_status"]."' ";
		if(!((int)$ary["money_status"]===-1)){
			if((int)$ary["money_status"]===0){
				$sql.=" AND c.car = '1' ";
			}elseif((int)$ary["money_status"]===1){
				$sql.=" AND c.house = '1' ";
			}elseif((int)$ary["money_status"]===2){
				$sql.=" AND c.car = '1' ";
				$sql.=" AND c.house = '1' ";
			}
		}
		if(!((int)$ary["child_status"]===-1))$sql.=" AND c.wanna_child = '".$ary["child_status"]."' ";
		if(!((int)$ary["job_addr"]===-1)){
			if((int)$ary["job_addr"]%10000===0){
				$sql.=" AND c.job_addr like '".strval((int)$ary["job_addr"]%10000)."%' ";
			}elseif((int)$ary["job_addr"]%100===0){
				$sql.=" AND c.job_addr like '".strval((int)$ary["job_addr"]%100)."%' ";
			}else{
				$sql.=" AND c.job_addr = '".$ary["job_addr"]."' ";
			}
		}
		
		
		$result = $mysql->getData($sql);
		$mysql->closeDb();
		return $result;
	}
	
	public function doSearch($val){
		$mysql = new SaeMysql();
		$sql="
		SELECT
			*
		FROM
		     `".SAE_MYSQL_DB."`.`".$this->table."` 
		where nickname like '%".$val."%' 
		or nickname like '%".urlencode($val)."%' 
		or id = '".$val."' 
		or tel = '".$val."' 
		or openid = '".$val."'
		"  ;
	
		$result = $mysql->getData($sql);
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $result;
	}
}
// 	a.id,a.openid,a.nickname,a.sex,a.photo,a.isvip,a.isreal,
//		    b.desc,c.job_addr,c.hometown,c.real_edu

//////////////////////////////
//
//        预约
//
//////////////////////////////
class orderRecord extends Record
{
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_order";
    }
   
    public function Add($openid, $name, $tel, $lab)
    {
		$time = time();
        $query = "INSERT INTO `hr_order` (`id`, `openid`, `name`, `tel`, `lab`, `create_time`, `finish`)
				 VALUES 
				 (NULL, '".$openid."', '".$name."', '".$tel."', '".$lab."', '".$time."', '0')";
        $result=mysql_query($query, $this->dbh);
        if($result) {
        	return mysql_insert_id();
        } else {
        	return $query;
        }
    }
}








class msgRecord extends Record
{
    function __construct()
	{
        parent::__construct();
        $this->table = "hl_message";
    }
   
    public function addOne($from,$to,$lab,$msg_key)
    {
        $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`from`,`to`,`create_time`,`is_read`,`lab`,`msg_key`) VALUES (NULL,'".$from."', '".$to."','".time()."','0', '".$lab."', '".$msg_key."' )"; 
        $result=mysql_query($query, $this->dbh);
        if($result) {
        	return mysql_insert_id();
        } else {
        	return $query;
        }
    }
    
    public function NewMsgCount($to){
        $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `to`='".$to."' AND `is_read`=0";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return 0;
		$row = mysql_fetch_array($result);
		return $row['q'];
    }
	
	public function NewMsgCountByFrom($from,$to){
	    $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `to`='".$to."' AND `from`='".$from."' AND `is_read`=0";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return 0;
		$row = mysql_fetch_array($result);
		return $row['q'];
	}
	public function NewInviteMsgCount($to){
	    $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `to`='".$to."' AND `is_read`=0 AND `lab` = 'invite'";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return 0;
		$row = mysql_fetch_array($result);
		return $row['q'];
	}
	
	public function NewNotInviteMsgCount($to){
	    $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `to`='".$to."' AND `is_read`=0 AND `lab` != 'invite'";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return 0;
		$row = mysql_fetch_array($result);
		return $row['q'];
	}
	// $page：页码-1,$pre：一页多少条
	public function getInviteMsgList($to,$page,$pre){
		$mysql = new SaeMysql();
	    $query = "SELECT
						MAX(m.id) id ,`from`,`to`,`create_time`,`is_read`,`lab`,`msg_key`,i.status,i.addr,i.meet_time,u.nickname,u.photo
					FROM
						`hl_message` AS m
					LEFT JOIN hl_invite i ON
						m.msg_key = i.id
					LEFT JOIN hr_user u on 
						m.from = u.openid
					WHERE
						(`to` = '".$to."' ) AND `lab` = 'invite'
						GROUP BY m.from
					ORDER BY m.`create_time` DESC
					";
		if($pre>0){
		    $f = $page*$pre;
		    $query .= "LIMIT ".$f.",".$pre;
		}
		$data = $mysql->getData( $query );
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $data;
	}
	
	public function getChatMsgList($to,$page,$pre){
		$mysql = new SaeMysql();
	    $query = "SELECT
						MAX(m.id) id ,`from`,`to`,`create_time`,`is_read`,`lab`,`msg_key`,u.nickname,u.photo
					FROM
						`hl_message` AS m
					LEFT JOIN hr_user u on 
						m.from = u.openid
					WHERE
						(`to` = '".$to."'  ) AND `lab` != 'invite'
						GROUP BY m.from,m.to
					ORDER BY m.`create_time` DESC
					";
		if($pre>0){
		    $f = $page*$pre;
		    $query .= "LIMIT ".$f.",".$pre;
		}
		$data = $mysql->getData( $query );
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
			return false ;
		}
		$mysql->closeDb();
		return $data;
	}
	
	public function getInviteById($from,$to){
		$mysql = new SaeMysql();
	    $query = "	SELECT
						m.`id`,`from`,`to`,`create_time`,`is_read`,`lab`,`msg_key`,i.status,i.addr,i.meet_time
					FROM
						`hl_message` AS m
					LEFT JOIN hl_invite i ON
						m.msg_key = i.id
					WHERE
						(
							(
								`from` = '".$from."' AND `to` = '".$to."'
							) OR(
								`to` = '".$from."' AND `from` = '".$to."'
							)
						) AND `lab` = 'invite'
					ORDER BY
						m.`id`
					DESC
				";
		
		$data = $mysql->getData( $query );
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $data;
	}
	
	public function getChatById($from,$to,$page){
		$mysql = new SaeMysql();
	    $query = "	SELECT
						m.`id`,`from`,`to`,`create_time`,`is_read`,`lab`,`msg_key`
					FROM
						`hl_message` AS m
					WHERE
						(
							(
								`from` = '".$from."' AND `to` = '".$to."'
							) OR(
								`to` = '".$from."' AND `from` = '".$to."'
							)
						) AND `lab` != 'invite'
					ORDER BY
						m.`id`
					DESC
				";
		$query .= "LIMIT ".$page.",10";
		$data = $mysql->getData( $query );
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $data;
	}
	
	
	public function readInvite($from,$to){
		$mysql = new SaeMysql();
	    $query = "	UPDATE
						`".SAE_MYSQL_DB."`.`".$this->table."`  
					SET `is_read` = '1'
					WHERE
						`from` = '".$from."'
						AND `to` = '".$to."'
						AND `lab` = 'invite'
				";
		
		$data = $mysql->runSql( $query );
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $data;
	}
	/**
	 * @param {Object} $from
	 * @param {Object} $to
	 */
    public function isInvited($from,$to)
    {
    	$query = "SELECT COUNT(*) q FROM  `".SAE_MYSQL_DB."`.`".$this->table."`  WHERE `to`='".$to."' AND  `from`='".$from."'";
    	$result = mysql_query($query, $this->dbh);
    	if(!$result)return $query;
    	$row = mysql_fetch_array($result);
    	return $row['q'];        
    }
}

//////////////////////////////
//
//        推广二维码
//
//////////////////////////////
class qrcodeRecord extends Record
{
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_qrcode";
    }
   
    public function Save($id,$name)
    {
        if($id>0)$row = $this->GetOne($id);
        else $row = false; 
        
        $time = time();
        if($row===false){  //添加               
            $query = "INSERT INTO `".SAE_MYSQL_DB."`.`".$this->table."` (`id`,`name`,`time`) VALUES (NULL,'".$name."','".$time."' )"; 
            mysql_query($query, $this->dbh);
            return mysql_insert_id();
        }
        else {  //更新
            $ary = array( "name"=>$name,"time"=>$time );
            $this->Update($row["id"],$ary);
            return $row["id"];
        }
    }
}





//////////////////////////////
//
//        VIP
//
//////////////////////////////
class UserVipRecord extends Record
{
    function __construct()
	{
        parent::__construct();
        $this->table = "hr_uservip";
    }
   
   /**
	* @param {Object} $userid
	* @param {Object} $vipClass
	* 根据用户id和会员种类查询一条用户VIP
	*/
   public function checkApply($userid,$vipClass){
   		$query = "select * from hr_uservip where user_id=".$userid." and vip_id=".$vipClass.";";
   		$result = mysql_query($query, $this->dbh);
   		return mysql_fetch_array($result);
   }
   
   /**
	* @param {Object} $userid
	* @param {Object} $vipClass
	* @param {Object} $number
	* 添加一条会员记录
	*/
   public function addOne($openid,$start_date,$end_date,$vip_id){
		
		$query = "INSERT INTO `hr_uservip` (`id`, `openid`, `start_date`, `end_date`, `uservip_status`, `vip_id`) VALUES (NULL, '".$openid."', '".$start_date."', '".$end_date."', '1', '".$vip_id."')";
		$result = mysql_query($query, $this->dbh);
		$query2 = "UPDATE `hr_user` SET `isvip` = 1 WHERE `openid`= '".$openid."'";
		$result2 = mysql_query($query2, $this->dbh);
		if($result&&$result2) {
			mysql_query("COMMIT");													//提交事务
			return true;
		} else {
			mysql_query("ROLLBACK");
			return false;
		}
   }
   
   public function getUserVipList($field,$value,$page,$pre){
		$mysql = new SaeMysql();
   		$sql = "SELECT
					u.id,u.openid,u.nickname,u.photo,u.sex,u.tel,u.join
				FROM
					".$this->table." uv
				LEFT JOIN hr_user u ON
					uv.openid = u.openid
				WHERE
					1
				AND uv.uservip_status=1 
				AND u.isvip=1 
					";
		if($field){
			$sql .= " AND  uv.`".$field."` = ".$value;
		}
		$f = $page*$pre;
		$sql .= " LIMIT ".$f.",".$pre;
   		$result = $mysql->getData($sql);
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
   		$mysql->closeDb();
   		return $result;
   }
   /**
	* @param {Object} $id userVIPid
	*/
   public function delOne($id){
	   $query1="DELETE FROM hr_contract WHERE uservip_id=".$id.";";
	   $query2="DELETE FROM hr_uservip WHERE id=".$id.";";
	   $result1 = mysql_query($query1, $this->dbh);
	   $result2 = mysql_query($query2, $this->dbh);
	   if($result1 && $result2) {
	   	mysql_query("COMMIT");
	   	return true;
	   } else {
	   	mysql_query("ROLLBACK");
	   	return false;
	   }
	   
   }
   
   public function delMany($ids){
	   $ary = explode(',',$ids);
	   for($i=0;$i<count($ary);$i++){
	   	if($ary[$i]=="")continue;
	   	$result = $this->delOne($ary[$i]);
	       if(!$result)return false;
	   }
	   return true;
   }
   
   public function stopOne($id){
	   $query2 = "UPDATE `hr_user` SET `isvip` = 0 WHERE `id`= '".$id."'";
	   $result2 = mysql_query($query2, $this->dbh);
	   if(!$result2)return false;
   	   return $this->updateStatus($id,0);
   	   
   }
   
   public function stopMany($ids){
   	   $ary = explode(',',$ids);
   	   for($i=0;$i<count($ary);$i++){
   	   	if($ary[$i]=="")continue;
   	   	$result = $this->stopOne($ary[$i]);
   	       if(!$result)return false;
   	   }
   	   return true;
   }
   
   public function startOne($id){
   	   return $this->updateStatus($id,1);
   	   
   }
   
   public function startMany($ids){
   	   $ary = explode(',',$ids);
   	   for($i=0;$i<count($ary);$i++){
   	   	if($ary[$i]=="")continue;
   	   	$result = $this->startOne($ary[$i]);
   	       if(!$result)return false;
   	   }
   	   return true;
   }
   
   public function updateStatus($id,$uservipStatus){
		$userRecord=new userRecord();
		$user = $userRecord->GetOne($id);
		if(!$user)return false;
		
		$query1="update hr_uservip set uservip_status=".$uservipStatus." where openid='".$user["openid"]."';";
		$result = mysql_query($query1, $this->dbh);
		
		if(!$result)return false;
		return true;
   }
   
   public function countByVipidAndStatus( $vip_id, $uservip_status )
   {
     
		$query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`vip_id`='".$vip_id."' AND `".$this->table."`.`uservip_status`='".$uservip_status."' ";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return false;
		$row = mysql_fetch_array($result);
		return $row['q'];
   }
   
   
   
}
//end uservip




   
class CheckCodeRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hr_checkcode";
	}
	/**
	 * @param {Object} $id
	 * @param {Object} $user_id 用户id
	 * @param {Object} $checkcode 验证码
	 * @param {Object} $create_time 发送时间
	 */
	public function addOne($user_id, $checkcode, $create_time){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `user_id`, `checkcode`, `create_time`) 
					VALUES (NULL, '".$user_id."', '".$checkcode."', '".$create_time."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
}


//////////////////////////////
//
//        用户基本资料表
//
//////////////////////////////
class BasicInfoRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_basic_info";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url
	 * @param {Object} $lab
	 */
	public function addOne($ary){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."` 
		(`id`, `openid`, `birthday`, `height`, `job_addr`, `education`,
		 `graduated_school`, `marital_status`, `child`, `wanna_child`, 
		 `job`, `salary`, `house`, `car`, `hometown`, `weight`, `smoke`, 
		 `drink`, `constellation`, `nation`, `when_marry`, `real_name`, `real_edu`) 
		VALUES 
		(NULL, '".$ary["openid"]."', '".$ary["birthday"]."', '".$ary["height"]."', '".$ary["job_addr"]."', '".$ary["education"]."',
				 '".$ary["graduated_school"]."', '".$ary["marital_status"]."', '".$ary["child"]."', '".$ary["wanna_child"]."', 
				 '".$ary["job"]."', '".$ary["salary"]."', '".$ary["house"]."', '".$ary["car"]."', '".$ary["hometown"]."', '".$ary["weight"]."', '".$ary["smoke"]."', 
				 '".$ary["drink"]."', '".$ary["constellation"]."', '".$ary["nation"]."', '".$ary["when_marry"]."', 0, 0)";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
}


//////////////////////////////
//
//        择偶标准表
//
//////////////////////////////
class SpouseSonditionRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_spouse_condition";
	}
	
	public function addOne($openid,$ary){
		$query1 = "INSERT INTO `hl_spouse_condition` 
					(`id`, `openid`, `min_age`, `max_age`, `min_height`, `max_height`,
					 `min_salary`, `max_salary`, `education`, `marital_status`, `min_weight`,
					  `max_weight`, `job_addr`, `child`, `wanna_child`, `smoke`, 
					  `drink`, `desc`, `house`, `car`) 
					VALUES 
					(NULL, '".$openid."', '".$ary["min_age"]."', '".$ary["max_age"]."', '".$ary["min_height"]."', '".$ary["max_height"]."',
					'".$ary["min_salary"]."', '".$ary["max_salary"]."', '".$ary["education"]."', '".$ary["marital_status"]."', '".$ary["min_weight"]."',
					'".$ary["max_weight"]."', '".$ary["job_addr"]."', '".$ary["child"]."', '".$ary["wanna_child"]."', '".$ary["smoke"]."',
					 '".$ary["drink"]."', '".$ary["desc"]."', '".$ary["house"]."', '".$ary["car"]."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
	
}


//////////////////////////////
//
//        图片表
//
//////////////////////////////
class ImgUrlRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_img_url";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $url, $lab){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `openid`, `url`, `lab`) 
					VALUES (NULL, '".$openid."', '".$url."', '".$lab."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
	/**
	 * @param {Object} $openid
	 * @param {Object} $lab
	 * @param {Object} $rows
	 */
	public function getByLab($openid, $lab,$rows){
		
		$query = "SELECT * FROM `hl_img_url` WHERE openid='".$openid."' and lab='".$lab."'";
		if($rows){
			$query.="limit ".$rows;
		}
		
		$result = mysql_query($query, $this->dbh);
		if(!$result){ $this->error = 4;return false;}
		$numRows = mysql_num_rows($result);
		if($numRows<1){ $this->error = 3;return false;}
		$array = array();
		for($i=0; $i<$numRows; $i++){
			mysql_data_seek($result, $i);
			$row = mysql_fetch_array($result);
			$array[] = $row;
		}       
		return $array;
	}
	
}


//////////////////////////////
//
//        视频表
//
//////////////////////////////
class VideoRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_video_url";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $url, $lab){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `openid`, `url`, `lab`) 
					VALUES (NULL, '".$openid."', '".$url."', '".$lab."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
}


//////////////////////////////
//
//        音频表
//
//////////////////////////////
class AudioRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_andio_url";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $url, $lab){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `openid`, `url`, `lab`) 
					VALUES (NULL, '".$openid."', '".$url."', '".$lab."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
}


//////////////////////////////
//
//        邀请表
//
//////////////////////////////
class InviteRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_invite";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($status,$addr,$meet_time){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `status`, `addr`, `meet_time`) 
					VALUES (NULL, '".$status."', '".$addr."', '".$meet_time."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
}

//////////////////////////////
//
//        日志表
//
//////////////////////////////
class logRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_log";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $lab){
		$query1 = "INSERT INTO  `".SAE_MYSQL_DB."`.`".$this->table."`  (`id`, `openid`, `lab`, `create_time`) 
					VALUES (NULL, '".$openid."', '".$lab."', '".time()."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
	/**
	 * @param {Object} $start_time
	 * @param {Object} $end_time
	 */
	public function CountByTime($start_time,$end_time){
		$query = "SELECT COUNT(DISTINCT openid) AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE 1";
		if($start_time){
			$query .=" AND `create_time` >= ".$start_time;
		}
		if($end_time){
			$query .=" AND `create_time` <= ".$end_time;
		}
		$result = mysql_query($query, $this->dbh);
		if(!$result)return false;
		$row = mysql_fetch_array($result);
		return $row['q'];   
	}
	/**
	 * @param {Object} $num 筛选数量
	 */
	public function getTopUser($num){
		$mysql = new SaeMysql();
		$query = "SELECT 
		    a.id `id`,a.openid `openid`,a.nickname `nickname`,a.sex `sex`,a.photo `photo`,
			b.desc `desc`,
			c.job_addr `job_addr`,c.hometown `hometown`,c.real_name `real_name`,c.real_edu `real_edu`,c.marital_status `marry_status`,
			d.vip_id `vip_id`,d.uservip_status `uservip_status`
			FROM
				hr_user a
			LEFT JOIN hr_uservip d ON
				a.openid = d.openid
			LEFT JOIN hl_basic_info c ON
				a.openid = c.openid 
			LEFT JOIN hl_spouse_condition b ON
				a.openid = b.openid
			WHERE d.uservip_status=1 AND
			a.openid IN (SELECT DISTINCT l.openid FROM hl_log l WHERE l.lab='login')
			LIMIT ".$num;//time()
		$result = $mysql->getData($query);
		$mysql->closeDb();
		return $result;
		
	}
}
 
class VerifyRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_verify";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $lab, $ag1=null, $ag2=null, $ag3=null, $ag4=null, $ag5=null){
		$query1 = "INSERT INTO `hl_verify` 
				(`id`, `openid`, `lab`, `create_time`, `status`, `ag1`, `ag2`, `ag3`, `ag4`, `ag5`) 
				VALUES 
				(NULL, '".$openid."', '".$lab."', '".time()."', '0', '".$ag1."', '".$ag2."', '".$ag3."', '".$ag4."', '".$ag5."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
	public function getOneByOpenidAndLab($openid,$lab){
		$mysql = new SaeMysql();
		$sql = "SELECT * FROM `hl_verify` WHERE `openid`='".$openid."' AND `lab`='".$lab."'";
		
		$result = $mysql->getLine($sql);
		if( $mysql->errno() != 0 )
		{
		    $this->errmsg=$mysql->errmsg();
		    return false ;
		}
		$mysql->closeDb();
		return $result;
	}
	
	
	public function countByLabAndStatus( $lab, $status )
	{
	    $this->error = 0;
	    if($this->table==""){$this->error = 1;return false;}
	    if($this->rule['get']==0){$this->error = 2;return false;}
	    
	    $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`lab`='".$lab."' AND `".$this->table."`.`status`='".$status."' ";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return false;
		$row = mysql_fetch_array($result);
		return $row['q'];
	}
	
	/**
	 * @param {Object} $ids
	 * @param {Object} $isPass
		
	 */
	public function verifyPass($ids,$isPass){
		if((int)$isPass===1){
			$a = explode(',',$ids);
			$result = true;
			$fun1 = new AuthenticateRecord();
			for($i=0;$i<count($a);$i++){
				if($a[$i]=="")continue;
				$res1 = $this->Update($a[$i],array("status"=>$isPass));
				if( $res1 === false)$result = false;
				
				$verify = $this->GetOne($a[$i]);
				$authenticate = $fun1->FindOne("openid",$verify["openid"]);
				if($authenticate===false){
					switch($verify["lab"]){
						case "real_name":
							$res2 = $fun1->addOne($verify["openid"],$verify["ag1"],$verify["ag2"],$verify["ag3"],$verify["ag4"]);
							
							$sexint = (int) substr(strval($verify["ag2"]), 16, 1);
							$sex = ($sexint % 2 === 0 ? 2 : 1);
							$query2 = "UPDATE `hr_user` SET `nickname` = '".$verify["ag1"]."' , `sex` = ".$sex." WHERE `openid`= '".$verify["openid"]."'";
							$res3 = mysql_query($query2, $this->dbh);
							
							break;
						case "real_edu":
							$res2 = $fun1->addOne($verify["openid"],null,null,null,null,$verify["ag1"],$verify["ag2"],$verify["ag3"]);
							break;
						case "real_referrer":
							$res2 = $fun1->addOne($verify["openid"],null,null,null,null,null,null,null,$verify["ag1"]);
							break;	
						case "real_vip":
							$fun2 = new UserVipRecord();
							$res2 = $fun2->addOne($verify["openid"],time(),0,$verify["ag1"]);
							$query2 = "UPDATE `hr_user` SET `isvip` = '1'  WHERE `openid`= '".$verify["openid"]."'";
							$res3 = mysql_query($query2, $this->dbh);
							break;	
						default:
							$res2 = false;
							break;
					}
					
				}else{
					switch($verify["lab"]){
						case "real_name":
							$res2 = $fun1->Update($authenticate["id"],array(
							"real_name"=>$verify["ag1"],
							"id_num"=>$verify["ag2"],
							"id_card_front"=>$verify["ag3"],
							"id_card_back"=>$verify["ag4"]
							));
							
							$sexint = (int) substr(strval($verify["ag2"]), 16, 1);
							$sex = ($sexint % 2 === 0 ? 2 : 1);
							$query2 = "UPDATE `hr_user` SET `nickname` = '".$verify["ag1"]."' , `sex` = ".$sex." WHERE `openid`= '".$verify["openid"]."'";
							$res3 = mysql_query($query2, $this->dbh);
							
							break;
						case "real_edu":
							$res2 = $fun1->Update($authenticate["id"],array(
							"edu"=>$verify["ag1"],
							"graduated_school"=>$verify["ag2"],
							"edu_photo"=>$verify["ag3"]
							));
							break;
						case "real_referrer":
							$res2 = $fun1->Update($authenticate["id"],array(
							"referrer_id"=>$verify["ag1"]
							));
							break;
						case "real_vip":
							$fun2 = new UserVipRecord();
							$res2 = $fun2->addOne($verify["openid"],time(),0,$verify["ag1"]);
							$query2 = "UPDATE `hr_user` SET `isvip` = '1'  WHERE `openid`= '".$verify["openid"]."'";
							$res3 = mysql_query($query2, $this->dbh);
							break;	
						default:
							$res2 = false;
							break;
					}
				}
				unset($fun1);
			}
		}else{
			$result = $this->UpdateMany($ids,array("status"=>$isPass));
		}
		return $result;
	}
	
	
	public function ListRecByLab($lab, $field,$value,$page,$pre,$desc )
	{
	    $this->error = 0;
	    if($this->table==""){$this->error = 1;return false;}
	    if($this->rule['get']==0){$this->error = 2;return false;}
		if($lab==="real_referrer"){
			$query = "SELECT vf.`id`,vf.`openid`,`lab`,`create_time`,`status`,`ag1`,`ag2`,`ag3`,`ag4`,`ag5`,u.id as userid,u.nickname,u2.nickname AS u2nickname
			 FROM `".SAE_MYSQL_DB."`.`".$this->table."` vf 
			 LEFT JOIN hr_user u ON vf.openid = u.openid 
			 LEFT JOIN hr_user u2 ON vf.ag1 = u2.id  
			 WHERE vf.`lab`='".$lab."' AND vf.`".$field."`='".$value."' ORDER BY `id` ";
		}else{
			if($field)$query = "SELECT vf.`id`,vf.`openid`,`lab`,`create_time`,`status`,`ag1`,`ag2`,`ag3`,`ag4`,`ag5`,u.id as userid,u.nickname  FROM `".SAE_MYSQL_DB."`.`".$this->table."` vf LEFT JOIN hr_user u ON vf.openid = u.openid WHERE vf.`lab`='".$lab."' AND vf.`".$field."`='".$value."' ORDER BY `id` ";
			else $query = "SELECT vf.`id`,vf.`openid`,`lab`,`create_time`,`status`,`ag1`,`ag2`,`ag3`,`ag4`,`ag5`,u.id as userid,u.nickname  FROM `".SAE_MYSQL_DB."`.`".$this->table."` vf  LEFT JOIN hr_user u ON vf.openid = u.openid  WHERE vf.`lab`='".$lab."'  ORDER BY `id` ";
		}
	    
	    if($desc)$query .= "DESC ";
	    if($pre>0){
	        $f = $page*$pre;
	        $query .= "LIMIT ".$f.",".$pre;
	    }
	    
	    $result = mysql_query($query, $this->dbh);
	    if(!$result){ $this->error = 4;return false;}
	    $numRows = mysql_num_rows($result);
	    if($numRows<1){ $this->error = 3;return false;}
	
	    $array = array();
		for($i=0; $i<$numRows; $i++){
			mysql_data_seek($result, $i);
			$row = mysql_fetch_array($result);
			$array[] = $row;
		}       
	
	    return $array;
	}
}

 
class AuthenticateRecord extends Record{
	function __construct()
	{
	    parent::__construct();
	    $this->table = "hl_authenticate";
	}
	
	/**
	 * @param {Object} $openid
	 * @param {Object} $url图片地址
	 * @param {Object} $lab标签
	 */
	public function addOne($openid, $real_name=null, $id_num=null, $id_card_front=null, $id_card_back=null, $edu=null, $graduated_school=null, $edu_photo=null, $referrer_id=null){
		$query1 = "INSERT INTO `hl_authenticate` 
					(`id`, `openid`, `real_name`, `id_num`, `id_card_front`, `id_card_back`, `edu`, `graduated_school`, `edu_photo`, `referrer_id`) 
					VALUES 
					(NULL, '".$openid."', '".$real_name."', '".$id_num."', '".$id_card_front."', '".$id_card_back."', '".$edu."', '".$graduated_school."', '".$edu_photo."', '".$referrer_id."')";
		$result1 = mysql_query($query1, $this->dbh);
		if($result1) {
			return mysql_insert_id();
		} else {
			return $query1;
		}
	}
	
}

?>

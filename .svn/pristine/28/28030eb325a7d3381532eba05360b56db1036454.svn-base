<?php
/////////////////////////////////////////
//
//      数据库管理基类
//      dbase.php
//
/////////////////////////////////////////
ini_set('date.timezone','Asia/Shanghai');
define("PWKEY", "sinlun_yipiao_hunlian");
define("STORAGE_BUCKET","yipiao");

class Record
{
    protected $dbh;      //数据库
    protected $table;    //表名称
    protected $rule;     //操作规则，指定哪些数据库操作不可以
    protected $error;    //错误代码
	protected $errmsg;    //错误代码

	function __construct()
	{
		$this->dbh =  mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
		mysql_select_db(SAE_MYSQL_DB, $this->dbh);
		mysql_query("SET NAMES utf8");
        
        $this->table = "";
        $this->rule = array( "ins"=>1,"del"=>1,"set"=>1,"get"=>1 );
        $this->error = 0;
	}
   
	function __destruct()
	{	
		mysql_close();
		
	}
    
    public function GetError()
    {
        return $this->error;
    }
	public function GetErrorMsg()
	{
	    return $this->errmsg;
	}
    
    //统计记录总数
    public function Count( $field, $value )
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
        
        if($field)$query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`".$field."`='".$value."'";
        else $query = "SELECT COUNT(*)  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."`";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return false;
		$row = mysql_fetch_array($result);
		return $row['q'];        
    }
    
    //对符合条件的某个字段总数
    public function Sum( $f, $field, $value )
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
        
        if($field)$query = "SELECT SUM( ".$f." )  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`".$field."`='".$value."'";
        else $query = "SELECT SUM( ".$f." )  AS q FROM `".SAE_MYSQL_DB."`.`".$this->table."`";
		$result = mysql_query($query, $this->dbh);
		if(!$result)return false;
		$row = mysql_fetch_array($result);
		return $row['q'];        
    }

    //根据ID查找一条记录
    public function GetOne( $id )
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
        
        $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`id`=".$id;
		$result = mysql_query($query, $this->dbh);
        if(!$result){$this->error = 3;return false;}
		$numRows = mysql_num_rows($result);
		if($numRows!=1){$this->error = 3;return false;}
        
        return mysql_fetch_array($result);
    }
    
    //根据字段查找一条记录
    public function FindOne( $field, $value, $desc=true )
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
       
        $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`".$field."`='".$value;
        if($desc)$query .= "'ORDER BY `id` DESC LIMIT 1";
        else $query .= "'ORDER BY `id` LIMIT 1";
        $result = mysql_query($query, $this->dbh);  
        $numRows = mysql_num_rows($result);
        if($numRows!=1){$this->error = 3;return false;}

        return mysql_fetch_array($result);
    }
	
	//根据字段查找一条记录
	public function FindOne2( $field, $value,$field2=1, $value2=1,$field3=1, $value3=1,$field4=1, $value4=1,$field5=1, $value5=1, $desc=true )
	{
	    $this->error = 0;
	    if($this->table==""){$this->error = 1;return false;}
	    if($this->rule['get']==0){$this->error = 2;return false;}
	   
	    $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."`
				WHERE  `".$field."`='".$value."' 
				AND  `".$field2."`='".$value2."' 
				AND  `".$field3."`='".$value3."'
				AND  `".$field4."`='".$value4."'
				AND  `".$field5."`='".$value5."'
				
				";
	    if($desc)$query .= "ORDER BY `id` DESC LIMIT 1";
	    else $query .= "ORDER BY `id` LIMIT 1";
	    $result = mysql_query($query, $this->dbh);  
	    $numRows = mysql_num_rows($result);
	    if($numRows!=1){$this->error = 3;return false;}
	
	    return mysql_fetch_array($result);
	}
    
    //根据字段查找多条记录  $page：页码,$pre：一页多少条
    public function ListRec( $field,$value,$page,$pre,$desc )
    {
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['get']==0){$this->error = 2;return false;}
       
        if($field)$query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`".$field."`='".$value."' ORDER BY `id` ";
        else $query = "SELECT * FROM `".SAE_MYSQL_DB."`.`".$this->table."` ORDER BY `id` ";
        
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
    
    public function DelOne( $id )
	{
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['del']==0){$this->error = 2;return false;}
        
		$query = "DELETE FROM `".SAE_MYSQL_DB."`.`".$this->table."` WHERE `".$this->table."`.`id`=".$id;
		mysql_query($query, $this->dbh);
		
		if( mysql_affected_rows() > 0)return true;
		return false;
    }
    
    public function DelMany( $ids )
	{
		$ary = explode(',',$ids);
		for($i=0;$i<count($ary);$i++){
			if($ary[$i]=="")continue;
			$result = $this->DelOne($ary[$i]);
            if(!$result)return $result;
			
			// if($this->table=="hr_user"){
				// $query2 = "UPDATE `hr_user` SET `vitae` = '0' WHERE `hr_user`.`vitae` = ".$id." ";
				// mysql_query($query2, $this->dbh);
			// }
		}
		return true;
    }
	
    /**
	 * @param {Object} $id 主键id
	 * @param {Object} $ary array('key'=>'value')
	 */
    public function Update( $id, $ary )
    {   
        //注意这里不会urlencode;
        $this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['set']==0){$this->error = 2;return false;}

        $str = "";
        foreach($ary as $key => $value)
        {
            $str .= "`".$key."`='";
            $str .= $value."',";
        }
        $str = substr($str,0,strlen($str)-1); //去掉最后那个逗号

        $query = "UPDATE `".SAE_MYSQL_DB."`.`".$this->table."` SET ".$str." WHERE `".$this->table."`.`id` =".$id; 
        mysql_query($query, $this->dbh);
        if( mysql_affected_rows() > 0)return true;
        return false;
    }
	
    public function UpdateMany( $ids, $ary )
    {
      	$this->error = 0;
        if($this->table==""){$this->error = 1;return false;}
        if($this->rule['set']==0){$this->error = 2;return false;}

        $str = "";
        foreach($ary as $key => $value)
        {
            $str .= "`".$key."`='";
            $str .= $value."',";
        }
        $str = substr($str,0,strlen($str)-1); //去掉最后那个逗号
     
        $a = explode(',',$ids);
        $result = true;
		for($i=0;$i<count($a);$i++){
			if($a[$i]=="")continue;
     
            $query = "UPDATE `".SAE_MYSQL_DB."`.`".$this->table."` SET ".$str." WHERE `".$this->table."`.`id` =".$a[$i]; 
        	mysql_query($query, $this->dbh);
            if( mysql_affected_rows() == 0)$result = false;
        }
        return $result;
    }
    
}
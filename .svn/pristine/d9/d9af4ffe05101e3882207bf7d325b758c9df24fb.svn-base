<?php
/////////////////////////////////////////
//
//      给第三方的 API接口
//
////////////////////////////////////////
require_once "fun.php";

if(!isset($_POST['operate'])){echo "未指定任何操作!";exit;}
if(!isset($_POST['data'])){echo "未指定参数!";exit;}

$operate = $_POST["operate"];
$data = $_POST["data"];
$ary = json_decode($data,true); 

switch( $operate ){		
	case "company":
        //$ary["name"] = urlencode($ary["name"]);
        //$ary["address"] = urlencode($ary["address"]);
        //$ary["intro"] = urlencode($ary["intro"]);        
        $fun = new companyRecord();
        $newid = $fun->Save(0,$ary);
        break;
    case "job":    
        //$ary["intro"] = urlencode($ary["intro"]);
        $fun = new jobRecord();
        $newid = $fun->Save(0,$ary);
        break;
}
if($newid===false)echo 0;
else echo $newid;

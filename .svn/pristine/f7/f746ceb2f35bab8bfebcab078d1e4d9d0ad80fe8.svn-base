<?php
session_start();
require_once "fun.php";
use sinacloud\sae\Storage as Storage;

	$msg = "";
	$path = "";

	if(!isset($_GET["uid"]))$msg = "请重新登录!";
	else {
		$userid = $_GET['uid'];
        if($userid=="web"){if(!isset($_SESSION['userid']))$msg = "请重新登录!";}
        else {
			$timestamp = $_GET['stamp'];
        	$token = $_GET['token'];
        
        	$now = time();
        	if( $now - $timestamp > 60*60*4 )$msg = "登录超时!";
        	else {
				$str = MD5($timestamp.PWKEY.$userid);
				if($str != $token)$msg = "验证错误!";
        	}
        }
    }
   
	if( $msg == ""){
        //$url = $_GET['url'];       
		$destFileName = $_GET['file'];
		$isUniq = $_GET['isUniq'];
		$domain = "yipiao";
		
		if(isset($_GET['file_id'])){
			$file_id = $_GET['file_id'];
		}else{
			$file_id = 'upfile';
		}
		
		$size = $_FILES[$file_id]['size'];
		if($size >20480*1024)$msg = "上传的文件不能大于2M!";
		else {
			$stor = new Storage();
		
			$from = basename($_FILES[$file_id]['name']);
            //$ext = substr($from,-4);
            $ext = substr($from,strrpos($from,"."));
			$ext = strtolower($ext);
			if($isUniq==true){
				$destFileName = $destFileName.$ext;
			}else{
				$destFileName = $destFileName.time()."_".uniqid().$ext;
			}
			
			if(($ext==".jpg")||($ext==".jpeg")||($ext==".png")||($ext==".txt")||($ext==".html")
			||($ext==".xml")||($ext==".json")||($ext==".pdf")||($ext==".gif")
			||($ext==".mp4")||($ext==".AVI")||($ext==".ts")||($ext==".flv")||($ext==".wmv")||($ext==".asf")||($ext==".rm")||($ext==".rmvb")||($ext==".mpg")
			||($ext==".mpeg")||($ext==".3gp")||($ext==".mov")||($ext==".webm")||($ext=="avi")
			||($ext==".mp3")||($ext==".MIDI")||($ext==".WAV"))  {
				$srcFileName = $_FILES[$file_id]['tmp_name'];
                //$attr = array('encoding'=>'gzip');
                //$result = $stor->upload($domain, $destFileName, $srcFileName);
                $result = $stor->putObjectFile($srcFileName,$domain, $destFileName);
				if(!$result)$msg = "图片上传失败!";
                //else $msg = "上传成功!";
                else $path = $stor->getUrl($domain, $destFileName);
			}
			else $msg = "不支持的文件类型!控件：".$file_id."类型：".$ext;
		}
	}

	//echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">alert("'.$msg.'");location="'.$url.'";</script></head></html>';
 	$ary = array('msg'=>urlencode($msg),'url'=>urlencode($path),'file'=> $destFileName);
    //$ary = array('msg'=>"ok3");
	$str = json_encode($ary);
	echo $str;

///////////////////////////////////////////
//   适用于Ajax上传， 引用掉的是原生上传
///////////////////////////////////////////

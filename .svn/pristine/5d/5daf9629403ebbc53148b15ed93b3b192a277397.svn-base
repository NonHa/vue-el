/////////////////////////////////////
//
//    JS扩展
//
//   (getSaeStorageUrl | Ajax | uploadAction中的url因项目不同而不同，注意修改!)
//
///////////////////////////////////



//Cookie操作
function GetCookie(c_name) {
	if (document.cookie.length>0)
	{
		var strCookie = document.cookie; 
		var arrCookie = strCookie.split("; "); 
		for(var i=0;i<arrCookie.length;i++){ 
			var arr = arrCookie[i].split("=");
			if(c_name == arr[0]){ 
				return unescape(arr[1]); 
				break; 
			} 
		} 
	}
	return false;
}

function SetCookie(c_name,value,time){
	if(time==0)document.cookie=c_name+ "=" +escape(value);
	else {
		var exp = new Date();
		exp.setTime(exp.getTime() + time*60*60*1000);
		document.cookie=c_name + "=" +escape(value) + ";expires=" + exp.toGMTString();
	}
}

function DelCookie(c_name){
	var value = GetCookie(c_name);
    if(value === false)return;
    
    var exp = new Date();
	exp.setTime(exp.getTime() - 1000);
    document.cookie=c_name + "=" +escape(value) + ";expires=" + exp.toGMTString();
}

///////////////////////////////////////////////////
//时间转字符串
function getDateString( time ){
    var myDate = new Date(time);
    var str = "";
    
    var str = myDate.getFullYear().toString(); //yyyy
    str += "-";
    
    var m = myDate.getMonth()+1; //0-11
    if(m<10)str += "0"+m;
    else str += m;
    str += "-";
    
    m = myDate.getDate();  //1-31
    if(m<10)str += "0"+m;
    else str += m;
    str += " ";
    
    var m = myDate.getHours();
    if(m<10)str += "0"+m;
    else str += m.toString();
    str += ":";
    
    m = myDate.getMinutes();
    if(m<10)str += "0"+m;
    else str += m;
    str += ":";
    
    m = myDate.getSeconds();
    if(m<10)str += "0"+m;
    else str += m;
    
    return str;
}

function getDayString(){
    var myDate = new Date();    
    var str = myDate.getFullYear().toString(); //yyyy
    
    var m = myDate.getMonth()+1; //0-11
    if(m<10)str += "0"+m;
    else str += m;
    
    m = myDate.getDate();  //1-31
    if(m<10)str += "0"+m;
    else str += m;
        
    return str;
}

function getTimeString(){
    var myDate = new Date();
    var str = "";
    
    var m = myDate.getHours();
    if(m<10)str += "0"+m;
    else str += m.toString();
    
    m = myDate.getMinutes();
    if(m<10)str += "0"+m;
    else str += m;
    
    m = myDate.getSeconds();
    if(m<10)str += "0"+m;
    else str += m;
 
    m = Math.floor(myDate.getMilliseconds()/10);
    if(m<10)str += "0"+m;
    else str += m;
    
    return str;
}

//将字符串时间(yyyy-MM-dd HH:mm:ss)转换成时间 
function StringToDate( str ){
    str = str.replace(/-/g,"/");
	return new Date( str );
}

///////////////////////////////////////////////////
//转换SaeStorage地址
function getSaeStorageUrl( file){
	return "http://yipiao-yipiao.stor.sinaapp.com/"+file;
}

//Ajax拉数据(重要!) 
//callback: Ajax成功后的回调函数
//data: 要POST的参数
function Ajax( callback, data ){    
    var myfunc = function(){};
	if(callback)myfunc = callback;
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var result = xmlhttp.responseText; 
			obj = JSON.parse(result);
            if((obj.Code==103)||(obj.Code==104)){
            	DelCookie("login_uid");
            	DelCookie("login_timestamp");
            	DelCookie("login_token");
                
                alert("连接超时，请重新登录。"+obj.Msg);
                window.opener = null;//为了不出现提示框
                window.open('','_top');
				window.top.close();
            }
			myfunc(obj);
		}
	}
    
    //加上token
    var login_uid = GetCookie("login_uid");
    if(login_uid !== false){
    	data.login_uid = login_uid;
    	data.login_timestamp = GetCookie("login_timestamp");
    	data.login_token = GetCookie("login_token"); 
    }
    
    var ary = [];
    for(var key in data){  
        ary.push(key + '=' + encodeURIComponent(data[key]));  
    }  
    var upstr = ary.join('&');  
	
	// url = "http://"+window.location.host;
	url = document.location.protocol + "//"+window.location.host;
    url += "/consoleapi.php";
	r = Math.random();
	url += "?rand=" + r; 

	xmlhttp.open("post",url,true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');  
	xmlhttp.send(upstr);
}

//处理文件上传文件名
//参数与upload.php配合
function uploadAction( file )
{
   var url = "http://"+window.location.host+"/upload.php?file=";   
   //加上存放位置
   url += encodeURIComponent( file );
   //加上要返回的页面(ajax不需要）
   //url += "&url=" + encodeURIComponent( window.location.href );
   //加上token
   var login_uid = GetCookie("login_uid");
   if(login_uid !== false){
        url += "&uid=" + login_uid;
        url += "&stamp=" + GetCookie("login_timestamp");
        url += "&token=" + GetCookie("login_token"); 
   }
   else return false;

   return url;
}

//html中获取参数
//href： window.location.search.substr(1);   
//location.search是从当前URL的?号开始的字符串
function GetArgsFromHref(href, key){
    if(href=="")return "";
        
    var str = href;
    var args = str.split("&");
    for(var i=0; i<args.length; i++){
        str = args[i];
        var arg = str.split("=");
        if(arg.length <= 1) continue;
        if(arg[0] == key) return arg[1]; 
    }
    return "";
}

//////////////////////////////////
//初始化自定义的radio和check，配合base.css
function init_baseinput( callback ){
    
    var myfunc = function(){};
	if(callback)myfunc = callback;
    
	var x = document.getElementsByTagName("div");
	for(var i=0;i<x.length;i++){
		if(hasClass(x[i],"base_check")){
			x[i].onclick = function (){ 
				toggleClass( this,"base_check_on" );
                myfunc( this );
			}
        }
        else if(hasClass(x[i],"base_radio")){
            x[i].onclick = function (){ 
                //toggleClass( this,"base_radio_on" );
                if(hasClass(this,"base_radio_on"))return;                
                var name = this.getAttribute("name");
                var y = document.getElementsByName(name);
				for(var m=0;m<y.length;m++)removeClass(y[m], "base_radio_on");
                addClass(this, "base_radio_on");
                myfunc( this );
            }
        }
    }            
}

//获得Radio中选中项的值
function GetRadioCheckedValue(name){
    var chkObjs = document.getElementsByName(name);
	for(var i=0;i<chkObjs.length;i++)
		if(chkObjs[i].checked)return chkObjs[i].value;
	return false;
}


/////////////////////////////////////////
//检查输入字符串是否为空或者全部都是空格
function isNull( str ){ 
	if ( str == "" ) return true; 
	var regu = "^[ ]+$"; 
	var re = new RegExp(regu); 
	return re.test(str); 
} 
	
//检查输入手机号码是否正确
function isMobile( s ){   
	var regu =/^[1][3|4|5|7|8][0-9]{9}$/; 
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}else{ 
		return false; 
	} 
} 

//检查输入字符串是否符合正整数格式
function isNumber( s ){   
	var regu = "^[0-9]+$"; 
	var re = new RegExp(regu); 
	if (s.search(re) != -1) { 
		return true; 
	} else { 
		return false; 
	} 
} 

//检查输入对象的值是否符合E-Mail格式 
function isEmail( str ){  
	var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
	if(myReg.test(str)) return true; 
	return false; 
} 
	
//检查输入字符串是否只由英文字母和数字和下划线组成 
function isNumberOr_Letter( s ){
	var regu = "^[0-9a-zA-Z\_]+$"; 
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}else{ 
		return false; 
	} 
} 
	
//检查输入字符串是否只由英文字母和数字组成 
function isNumberOrLetter( s ){
	var regu = "^[0-9a-zA-Z]+$"; 
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}else{ 
		return false; 
	} 
} 

//检查输入字符串是否只由汉字组成 
function isChinese( s ){
	var regu = "^[\u4e00-\u9fa5]+$";   
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}else{ 
		return false; 
	} 
} 
	
//检查输入字符串是否只由汉字、字母、数字组成 
function isChinaOrNumbOrLett( s ){
	var regu = "^[0-9a-zA-Z\u4e00-\u9fa5]+$";   
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}else{ 
		return false; 
	} 
} 
	
//检查输入字符串是否出生年份
function isBirthday( birth ){
	var myDate = new Date();
	var year = myDate.getFullYear(); 
	if((year - birth < 0)||(year - birth > 100)){
		return false; 
	}else{ 
		return true; 
	} 
}

//检查数组中有没有字符串
function in_array(ary, str)
{
    var k = ary.length;
	if(!k)return false;
    
    // 遍历是否在数组中    
	for(var i=0;i<k;i++){
    	if(ary[i]==str)return true;  
    }
	return false;
}

//数字前面填充0
function zeroFill(num, size) {
    var s = "000000000" + num;
    return s.substr(s.length-size);
}
////////////////////////////////////////   
//对css类的操作
function hasClass(obj, cls)
{  
    return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));  
}  
  
function addClass(obj, cls)
{  
	if (!this.hasClass(obj, cls)) obj.className += " " + cls;  
}  
 
function removeClass(obj, cls)
{  
	if (hasClass(obj, cls)) {  
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');  
     	obj.className = obj.className.replace(reg, ' ');  
	}  
}  

function toggleClass(obj,cls)
{  
    if(hasClass(obj,cls))removeClass(obj, cls);  
    else addClass(obj, cls);  
}


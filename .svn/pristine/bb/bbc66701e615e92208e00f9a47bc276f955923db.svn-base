/////////////////////////////////////
//
//    JS扩展
//
//   (getSaeStorageUrl | Ajax | uploadAction中的url因项目不同而不同，注意修改!)
//
///////////////////////////////////


// $(document).ready(function(){
// 	$("body").append('<div class="null_bottom_bar" ></div>');
// 	$("body").append('<div class="bottom_bar" ></div>');
// 	$('.bottom_bar').append('<button type="button" onclick="goIndex()">首页<img src="" ></button>',
// 							'<button type="button" onclick="user_msg()">消息<img src="" ></button>',
// 							'<button type="button" onclick="go_myspace()">我<img src="" ></button>');
// });
var $ = layui.$;
var user_id = 0;
var session = {};
addBottomBar();

$("#exit").hide();
function checkLogin(){
	if (parseInt(user_id) == 0||user_id==undefined) {
		$("#touxiang").attr("src",document.location.protocol + "//"+window.location.host+"/pages/img/default.jpg");
		$("#exit").hide();
		$("#login").show();
	} else{
		$("img[name='touxiang']").attr("src",decodeURIComponent(session.photo));
		$("#nickname").html(decodeURIComponent(session.nickname));
		$("#exit").show();
		$("#login").hide();
	}
}

/**
 * 退出登录
 */
function exit(){
	var data = {"operate":"exitWeb"};
	Ajax(ajax_exit, data);
}
/**
 * 登录
 */
function login1(){
	//iframe层
	layer.open({
	  type: 2,
	  title: '登录',
	  shadeClose: true,
	  shade: 0.8,
	  area: ['600px', '30%'],
	  content: "login.html" //iframe的url
	}); 
}

function  ajax_exit(obj){
	if(obj.Code>0)alert(obj.Msg);
	else { 
		session = obj.session;
		user_id = session.userid;
		$("#nickname").html("未登录");
		$("#login").show();
		$("#touxiang").attr("src",document.location.protocol + "//"+window.location.host+"/pages/img/default.jpg");
		$("#exit").hide();
	}
}


function addBottomBar(){
	if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
		var div1 = document.createElement("div");
		div1.className="null_bottom_bar";
		document.body.appendChild(div1);
		var div2 = document.createElement("div");
		div2.className=("bottom_bar");
		document.body.appendChild(div2);
		var oText1='<button type="button" onclick="goIndex()"><i class="layui-icon layui-icon-home" style="font-size: 30px; color: #FF5722;"></i>  </button>';
		var oText2='<button type="button" onclick="user_msg()"><i class="layui-icon layui-icon-dialogue" style="font-size: 30px; color: #FF5722;"> </i></button>';
		var oText3='<button type="button" onclick="go_myspace()"><i class="layui-icon layui-icon-username" style="font-size: 30px; color: #FF5722;"></i></button>';
		div2.innerHTML=oText1+oText2+oText3; 
	} else {
		return;
	}
	
}
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
		document.cookie=c_name + "=" +escape(value) + ";expires=" + exp.toGMTString()+";path=/";  
	}
}

function DelCookie(c_name){
	var value = GetCookie(c_name);
    if(value === false)return;
    
    var exp = new Date();
	exp.setTime(exp.getTime() - 1000);
    document.cookie=c_name + "=" +escape(value) + ";expires=" + exp.toGMTString()+";path=/";  
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
    // str += ":";
    
    // m = myDate.getSeconds();
    // if(m<10)str += "0"+m;
    // else str += m;
    
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

function StringToDate( str ){
    str = str.replace(/-/g,"/");
	return new Date( str );
}

///////////////////////////////////////////////////
//转换SaeStorage地址
function getSaeStorageUrl( file){
	return "http://bing-snow.stor.sinaapp.com/"+file;
}

//Ajax拉数据(重要!) 
//callback: Ajax成功后的回调函数
//data: 要POST的参数
function Ajax( callback, data ){
    console.log("post:");
    console.log(data);
    var myfunc = function(){};
	if(callback)myfunc = callback;
	/*
    var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp = new XMLHttpRequest();
  	}
	else  {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
    */
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var result = xmlhttp.responseText; 
			obj = JSON.parse(result); 
					   
			myfunc(obj);
		}
	}
    
    var ary = [];
    for(var key in data){  
        ary.push(key + '=' + encodeURIComponent(data[key]));  
    }  
    var upstr = ary.join('&');  
	// console.log("window.location.host********"+window.location.host);
	// console.log("document.location.protocol**********"+document.location.protocol);
	url = document.location.protocol + "//"+window.location.host;
    ////////////////////////////////////////
    //   以下这行注意，与控制台下面的js不同
    ///////////////////////////////////////
	url += "/webapi.php";  
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
   var url = "../upload.php?file=";   
   url += encodeURIComponent( file );
   url += "&uid=web";
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

//身份证验证;
function isCardNo( str ) {
	if (!checkCardLength(str))return false;
    if (!checkProvince(str))return false;
        
    if (str.length == 15) {
        return isValidityBrithBy15IdCard(str);
    }else if (str.length == 18){
        var a_idCard = str.split("");// 得到身份证数组
        if (isValidityBrithBy18IdCard( str )&&isTrueValidateCodeBy18IdCard( a_idCard ))return true;
        return false;
    }
    return false;
}
    
    function checkCardLength( s ){
        //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X
        var reg = /(^\d{15}$)|(^\d{17}(\d|X)$)/;
        if (reg.test(s))return true; 
		else return false; 
    }                            

    //取身份证前两位,校验省份
	function checkProvince( s ){
        //身份证省的编码
        var vcity={ 11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",
                    21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",
                    33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",
                    42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",
                    51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",
                    63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"
                  };
        
		var province = s.substr(0,2);
        if(vcity[province] == undefined )return false;
        return true;
    }
    

    function isTrueValidateCodeBy18IdCard(a_idCard) {
        var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];  // 加权因子;
        var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];  // 身份证验证位值，10代表X;
        
    	var sum = 0; // 声明加权求和变量
        if (a_idCard[17].toLowerCase() == 'x')a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
        for ( var i = 0; i < 17; i++)sum += Wi[i] * a_idCard[i];// 加权求和
        valCodePosition = sum % 11;// 得到验证码所位置
        if (a_idCard[17] == ValideCode[valCodePosition])return true;
        return false;
    }
    
    function isValidityBrithBy18IdCard(idCard18){
		var year = parseInt(idCard18.substring(6,10));
        var month = parseInt(idCard18.substring(10,12));
        var day = parseInt(idCard18.substring(12,14));
        var temp_date = new Date(year,month-1,day);
        if(temp_date.getFullYear() != year || temp_date.getMonth()!=month-1 || temp_date.getDate()!=day)return false;
        return true;
    }

    function isValidityBrithBy15IdCard(idCard15){
		var year = parseInt( idCard15.substring(6,8));
        var month = parseInt(idCard15.substring(8,10));
        var day = parseInt(idCard15.substring(10,12));
        var temp_date = new Date(year,month-1,day);
        // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
        if(temp_date.getYear()!=year || temp_date.getMonth()!=month-1 || temp_date.getDate()!=day)return false;
        return true;
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
	var regu =/^1(3[0-9]|4[5,7]|5[0,1,2,3,5,6,7,8,9]|6[2,5,6,7]|7[0,1,7,8]|8[0-9]|9[1,8,9])\d{8}$/;
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

function checkPwdForm(s){
	var regu = "^[0-9a-zA-Z\+\-\*\/\.\_]+$";
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
	if (!hasClass(obj, cls)) obj.className += " " + cls;  
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

/////////////////////////////////////
//将图片居中
function midPic( x,w,h ){ 
	var img = new Image();//创建一个image对象
	img.src = x.src;
    if(h*img.width<w*img.height){
        x.style.width = w+"px";
        x.style.height = "auto";
        x.style.left = "0px";
        x.style.top = (h-Math.floor(w*img.height/img.width))/2+"px";
    }
    else {
        x.style.height = h+"px";
        x.style.width = "auto";
        x.style.top = "0px";
        x.style.left = (w-Math.floor(h*img.width/img.height))/2+"px";
    }
}

////////////////////
//
//update by wupan
//
//////////////////////


//返回首页函数
function goIndex(){
	location=document.location.protocol + "//"+window.location.host;
}

//点击头像或昵称进入个人信息界面
function go_myspace(){
	location = document.location.protocol + "//"+window.location.host+"/pages/userbase.html";
}

function user_msg(){
	location = document.location.protocol + "//"+window.location.host+ "/pages/message.html";
}
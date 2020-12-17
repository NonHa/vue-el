var $=layui.$;
var to = "";
$(window).scroll(function () {
	var wst = $(window).scrollTop(); //这里可以加滚动事件
	
});

$(document).ready(function(){
	var data={"operate":"getBasicInfo"};
	Ajax(function(){
		if(obj.Code>0)layer.msg(obj.Msg);
		else {
			 //我的信息
		 	var ary = JSON.parse(obj.Result); 
		 	session = obj.session;
		 	user_id = session.userid;
		 	checkLogin();
			if(ary.user.photo){
				$("img[name='touxiang']").attr("src",decodeURIComponent(ary.user.photo));
			}
		}
	},data);
	//根据ID查信息
	var req=GetRequest();
	console.log(req.id);
	let operate={"operate":"getUserByID","id":req.id};
	//显示
	Ajax(showperson,operate);
	
});


function imgShow(outerdiv, innerdiv, bigimg, _this){
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性 
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性 
      /*获取当前点击图片的真实大小，并显示弹出层及大图*/
    $("<img/>").attr("src", src).load(function(){ 
      var windowW = $(window).width();//获取当前窗口宽度 
      var windowH = $(window).height();//获取当前窗口高度 
      var realWidth = this.width;//获取图片真实宽度 
      var realHeight = this.height;//获取图片真实高度 
      var imgWidth, imgHeight; 
      var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放 
      if(realHeight>windowH*scale) {//判断图片高度 
        imgHeight = windowH*scale;//如大于窗口高度，图片高度进行缩放 
        imgWidth = imgHeight/realHeight*realWidth;//等比例缩放宽度 
        if(imgWidth>windowW*scale) {//如宽度扔大于窗口宽度 
          imgWidth = windowW*scale;//再对宽度进行缩放 
        } 
      } else if(realWidth>windowW*scale) {//如图片高度合适，判断图片宽度 
        imgWidth = windowW*scale;//如大于窗口宽度，图片宽度进行缩放 
		imgHeight = imgWidth/realWidth*realHeight;//等比例缩放高度 
      } else {//如果图片真实高度和宽度都符合要求，高宽不变 
        imgWidth = realWidth; 
        imgHeight = realHeight; 
      } 
      $(bigimg).css("width",imgWidth);//以最终的宽度对图片缩放 
      var w = (windowW-imgWidth)/2;//计算图片与窗口左边距 
      var h = (windowH-imgHeight)/2;//计算图片与窗口上边距 
      $(innerdiv).css({"top":h, "left":w});//设置#innerdiv的top和left属性 
      $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg 
    }); 
    $(outerdiv).click(function(){//再次点击淡出消失弹出层 
      $(this).fadeOut("fast"); 
    }); 
}

function showperson(obj){
	if(obj.Code>0)layer.msg(obj.Msg);
	else {
		var result=JSON.parse(obj.Result);
		to = result.user.openid;
		console.log(result.user);
		//个人信息
		if(result.user){
			
			$("img[name='personicon']").attr("src",decodeURIComponent(result.user.photo));
			if(result.user.sex =='2'){
				$("#u1").append('<h2 align="center">她的资料</h2>');
			}else if(result.user.sex == '1'){
				$("#u1").append('<h2 align="center">他的资料</h2>');
			}
			var tt=isMobile(result.user.tel)?result.user.tel:'未填写';
			
			var sttr=' ';
			if(result.vipinfo.vip_id==1){
				sttr='<i class="layui-icon layui-icon-diamond" title="一瓢联合创始人" style=" font-size:20px; color: #e10f12;" ></i> ';
			}else{
				sttr='<i class="layui-icon layui-icon-diamond" title="一瓢会员" style=" font-size:20px; color: #0055ff;" ></i> ';
			}
			$("#u2").append('<h4 class="tag" >昵称：'+decodeURIComponent(result.user.nickname)+sttr+'</h4>');
			$("#u2").append('<h4 class="tag">电话号码：'+tt+' <i class="layui-icon layui-icon-cellphone" title="手机号已认证" style=" font-size:20px; color: #27c71e;" ></i></h4>');
			
		}
		if(result.auth){
			if(result.auth.real_name){
				$("#u2").append('<h4 class="tag">真实姓名：'+decodeURIComponent(result.auth.real_name)+' <i class="layui-icon layui-icon-username" title="实名已认证" style=" font-size:20px; color: #27c71e;" ></i></h4>');
			}
			if(result.auth.graduated_school){
				$("#u2").append('<h4 class="tag">毕业学校：'+decodeURIComponent(result.auth.graduated_school)+'<i class="layui-icon layui-icon-release" title="学历已认证" style=" font-size:20px; color: #27c71e;" ></i></h4>');
			}
			if(result.auth.referuser){
				$("#u2").append('<h4 class="tag">会员推荐人：<a href="http://www.yipiaohunlian.com/pages/person.html?id='+result.auth.referuser.id+'" target="_blank" >'+decodeURIComponent(result.auth.referuser.nickname)+' <i class="layui-icon layui-icon-user" title="优秀推荐人" style="font-size:20px; color: #27c71e;" ></i> </a></h4>');
			}
		}
		
		if(result.album){
			var area=$("#personalbum");
			for(let i=0;i<result.album.length;i++){
				let iurl=decodeURIComponent(result.album[i].url);
				if(iurl){
					area.append('<li class="imgflow"> <img src="'+iurl+'" class="pimg imgflow"></li>');
				}
			}
		}
		//详细信息
		if(result.base){
			dealdata(result.base,1);
			layui.form.val("usedetail",result.base);
			$("#uid1").attr("class","layui-show");
		}else{
			layui.form.val("usedetail","未填写");
		}
		//择偶标准
		if(result.mate){
			dealdata(result.mate,2);
			layui.form.val('wantmate',result.mate);
			$("#uid2").attr("class","layui-show");
		}else{
			layui.form.val("wantmate","未填写");
		}
		
		$(".pimg").click(function(){
		  var _this = $(this);//将当前的pimg元素作为_this传入函数
		  imgShow("#outerdiv", "#innerdiv", "#bigimg", _this); 
		});
	}
}

function GetRequest() {//获取url中"?"符后的字串
	var url = location.search; 
	var theRequest = new Object();//创建对象，并赋值给对象键值来获取url的参数。
	if (url.indexOf("?") != -1) {
		var str = url.substr(1);
		strs = str.split("&");
		for(var i = 0; i < strs.length; i ++) {
			theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
		}
	}
	return theRequest;
}
	
//填值
function dealdata(array,type){
	//自己
	if(type==1){
		var y1=new Date(array.birthday);
		var y2=new Date();
		var year1=y1.getFullYear();
		var year2=y2.getFullYear();
		var res=year2-year1;
		array.birthday=res+" 岁";
		//身高
		array.height=array.height+" cm";
		//体重
		array.weight=array.weight+" kg";
		//星座
		var stu=constellations[array.constellation];
		array.constellation=stu.Name;
		//吸烟，喝酒，房，车
		array.smoke=smokes[array.smoke];
		array.drink=drinks[array.drink];
		array.child==1?array.child="有孩子":array.child="无孩子";
		array.house==1?array.house="已购房":array.house="未购房";
		array.car==1?array.car="已购车":array.car="未购车";
		//是否想要孩子
		array.wanna_child=wanna_childs[array.wanna_child];
		//月薪
		array.salary=salarys[array.salary];
	}
	//配偶
	if(type==2){
		var dd;
		if(sal[array.min_salary]){
			dd=sal[array.min_salary];
		}else{
			dd="不限";
		}
		dd+=" 到 ";
		if(sal[array.max_salary]){
			dd+=sal[array.min_salary];
		}else{
			dd+="不限";
		}
		array.salary=dd;
		for(var a in array){
			if(array[a]=="-1"){	
				array[a]="不限";
			}
		}
		array.age=array.min_age+" 到 "+array.max_age;
		array.high=array.min_height+" 到 "+array.max_height;
		array.weight=array.min_weight+" 到 "+array.max_weight;
		array.smoke=matesmokes[array.smoke]?matesmokes[array.smoke]:"吸烟不限";
		array.drink=matesdrinks[array.drink]?matesdrinks[array.drink]:"喝酒不限";
		array.child==1?array.child="可以有孩子":array.child="无孩子";
		array.house==1?array.house="已购房":array.house="未购房";
		array.car==1?array.car="已购车":array.car="未购车";
		//是否想要孩子
		array.wanna_child=mateswanna_childs[array.wanna_child];
		if(!array.desc){
			array.desc="未填写";
		}
	}
	//以下是通用
	//准备何时结婚
	array.when_marry=when_marrys[array.when_marry];
	//学历
	array.education=EDUCATIONS[array.education];
	//婚姻状况
	array.marital_status=marital_statuss[array.marital_status];
	//工作地区
	var code="";
	if(array.job_addr==-1 || array.job_addr=="不限"){
		array.job_addr="不限地区";
	}else{
		var area=array.job_addr;
		var province=area.substring(0,2)+"0000";
		var city=area.substring(0,4)+"00";
		if(areaList.province_list[area]){
			code+=areaList.province_list[area]+"内";
		}else if(areaList.city_list[area]){
			code+=areaList.province_list[province]+"-";
			code+=areaList.city_list[area]+"内";
		}else{
			code+=areaList.province_list[province];
			code+="-"+areaList.city_list[city];
			code+="-"+areaList.county_list[area];
		}
		array.job_addr=code;
	}
	
}


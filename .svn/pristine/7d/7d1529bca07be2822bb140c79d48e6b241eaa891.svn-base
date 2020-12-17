
//用户输入搜索
function usersearch() {
	//清空当前ul
	$(".userflow").empty();
	Ajax(function(obj){
		showdata(obj);
	},{"operate":"getSearch","sid":$("#idsearch").val()});
}
//用户条件筛选
$(function(){
	var form = layui.form;
	form.on('submit', function(data){
		console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
		console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
		console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
		//是VIP的，直接搜
		if (session.isvip) {
			if(data.field.county==""){
				if (data.field.city=="") {
					data.field.job_addr=data.field.province;
				} else{
					data.field.job_addr=data.field.city;
				}
			}else{
				data.field.job_addr=data.field.county;
			}
			delete data.field.province;delete data.field.city;delete data.field.county;
			var postData = {"ary":JSON.stringify(data.field),"operate":"preciseSearch"};
			Ajax(ajax_submit,postData);
		}else{
			checkvip();
		}
		return false;
	});
})
function ajax_submit(obj){
	if(obj.Code>0)layer.msg(obj.Msg);
	else {
		$(".userflow").empty();
		showdata(obj);
	}
}

//开始推荐进入
function recommend(obj){
	if(obj.Code>0)alert(obj.Msg);
	else {
		session = obj.session;
		user_id = session.userid;
		checkLogin();
		showdata(obj);
	}
}

/*
 * 1.VIP推荐界面显示用户流
 * 2.搜索筛选界面显示用户流
 * 3.首页推荐用户流
 */
//传入要显示的数据
function showdata(obj) {
	var flow=layui.flow;
	var reusers = JSON.parse(obj.Result);
	var edd=" ";
	var te=window.location.pathname;
	if( te.substring(te.lastIndexOf('/')+1,te.length) != "search.html"){
		edd='<div class="layui-row" >查看更多用户请使用<a href="search.html">搜索<a/></div>';
	}
	if(!reusers){
		$(".userflow").append('<p class="layui-text" align="center">没有搜索到用户！</p>');
	}else{
		var totalnum=reusers.length;
		flow.load({
			elem: '.userflow', //流加载容器
			isAuto: true, //手动or自动
			done: function(page, next) { //加载方法，每下滚一次就加载一次
				setTimeout(function() {
					var lis = [];
					for (var i = 0; i < 6; i++) { //一页6个
						var u = ((page - 1) * 6 + i); //数量从0开始
						if(!reusers[u]){
							break;
						}
						if(reusers[u].openid==session.openid){
							continue;
						}
						let namearea=decodeURIComponent(reusers[u].nickname);
						if(namearea.length>5){
							namearea=namearea.substring(0,5)+"..";
						}
						if(reusers[u].uservip_status == 1){//会员过期不展示
							if(reusers[u].vip_id == 1){
								namearea+='<i class="layui-icon layui-icon-diamond" title="一瓢联合创始人" style=" font-size:20px; color: #e10f12;" ></i> ';
							}else{
								namearea+='<i class="layui-icon layui-icon-diamond" title="一瓢会员" style=" font-size:20px; color: #0055ff;" ></i> ';
							}
						}
						if(reusers[u].real_name == 1){
							namearea+='<i class="layui-icon layui-icon-auz" title="实名已认证" style=" font-size:20px; color: #31ff27;" ></i> ';
						}
						if(reusers[u].real_edu == 1){
							namearea+='<i class="layui-icon layui-icon-read" title="学历已认证" style=" font-size:20px; color: #31ff27;" ></i> ';
						}
						
						let infoarea = transarea(reusers[u].job_addr);
						if(!infoarea){
							infoarea="TA未填写地区"; 
						}else if(infoarea.length>8){
							infoarea=infoarea.substring(0,8)+"...";
						}
						let matearea=reusers[u].desc;
						if(!matearea){
							matearea="TA未填写自我介绍";
						}
						lis.push(
							'<li><div class="layui-col-md6 layui-col-sm6 layui-col-xs12 layui-col-space10"><div class="layui-col-md4 layui-col-sm4 layui-col-xs5"><a href="person.html?id=' + reusers[u].id + '" target="_blank">' +
							'<img style="width: 100%; display:block;" src="' + decodeURIComponent(reusers[u].photo) + '" class="headicon"/>' +
							'</a></div><div class="layui-col-md8 layui-col-xs7" style=" margin-top:10px; font-size: medium;">' +
							'<p>'+ namearea +'</p>' +
							'<p class="addr">'+ infoarea +'</p>' +
							'<em>'+ matearea +'</em>' +
							'</div></div></li>'
							);
					}
					next(lis.join(''), page < (totalnum/6)+1);
				}, 500);
			},
			end: edd
		});
	}
}

//将传入的区位码显示成文字
function transarea(str){
	var code;
	if(str){
		// var province=str.substring(0,2)+"0000";
		var city=str.substring(0,4)+"00";
		// code=areaList.province_list[province];
		code = areaList.city_list[city];
		code += "-"+areaList.county_list[str];
	}
	return code;
}

//弹出会员提示框
function checkvip(){
	layer.open({
	    type: 1,
	    shadeClose: false,
		closeBtn: 0,
		anim: 2,
	    title: '开通会员之后才可以使用会员搜索哦',
		btn:['确认','取消'],
		btn1: function(){
			window.open("viewvip.html");
			layer.closeAll();
		}
	});
}

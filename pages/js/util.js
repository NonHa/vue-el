var $ = layui.$;
//配置插件目录
layui.config({
	base: 'js/',
	version: '1.0'
});
//侧边栏
$(function(){
	//三个侧栏按钮
	$( "#toTop").click( function (){
		$( "html,body").animate({ "scrollTop" : 0 }, 500);
	});
	
	$( "#showqr").click( function (){
		var img = '<img src="img/qrcode_for_gh_0d3d8e8259fa_258.jpg" />';  
			layer.open({  
			    type: 1,  
			    shade: false,  
			    title: '微信扫码关注我们', 
			    content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响  
			});  
	});
	
	$( "#callme").click( function (){
		layer.alert("电话联系我们123456789",{
			icon: 6,
			skin: 'layer-ext-moon' 
		})
	});
	//日期,地区组件
	layui.use(['laydate','layarea'], function() {
		
		var laydate = layui.laydate,
			layarea = layui.layarea;
		laydate.render({
			elem: '#brithday',
			trigger: 'click',
		});
		layarea.render({
			elem: '#area-picker',
			change: function(res) {
				//选择结果
				console.log(res);
			}
		});
	
	});
});

//得到网页get参数
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}


function IconUpload(user_id){
	//图片上传
	var files={};
	if(user_id==0){alert("您还未登录！");return;}
	var upload=layui.upload;
	var lab;
	upload.render({
		elem: '.site-demo-upload'
		//,auto: false
		,acceptMime: 'image/*'
		,multiple: true
		,url: ""
		,field:"file"//控件name
		,choose: function(obj){
			var item=this.item;
			files = this.files = obj.pushFile();  //将每次选择的文件追加到文件队列
			if(item.is("button")){//判断上传类型	
				lab = "album";
				var newfile = "img/album/" + user_id + "/";
				this.field="albumfile";
				obj.preview(function (index, file, result) {
					$('#preview').append('<div style="margin:0 10px; display:inline-block !important; display:inline;  max-width:200px; max-height:200px;">' +
					'<img onclick="del_photo(this)" class="showimg" style="width: 100%;height:100%" src="' + result + '" id="' + file.name + '"></div>');
				});
			}else{
				lab = "headicon";
				newfile = "img/headicon/" + user_id + "/";
				this.field="headfile";
				obj.preview(function (index, file, result) {
					$("img[name='touxiang']").attr("src",result);
				});
			}
			this.url = "../upload.php?file="+encodeURIComponent( newfile );
			this.url += "&file_id="+this.field;	
			this.url += "&uid=web";
		},before: function(obj){
			layer.load(1);
		}
		,done: function(data,index){
		  //上传完毕
		  if(typeof(data.msg) != 'undefined'){
			if(data.msg == ''){
				delete files[index];
				var data ={"operate":"addImg","lab":lab,"url":data.url};
				if(lab=='headicon'){//头像修改
					let i = {"operate":"updateImg","id":user_id,"photo":data.url};
					Ajax(function(obj){
						if(obj.Code>0)alert(obj.Msg);
						else {
							var ary = JSON.parse(obj.Result); 
							console.log(ary);
							layer.msg('头像修改成功'); 
							window.location.reload();
						}
					},i);
				}
				Ajax(ajax_addImg,data);
			}else {
				alert(decodeURIComponent(data.msg));
			}
		  }else{
			  alert("图片上传异常");
		  }
		  layer.closeAll('loading'); //关闭loading
		}
		,error: function(){
			//请求异常回调
			console.log("图片上传失败!");
			layer.closeAll('loading'); //关闭loading
		}
	});
	
}




//添加age,height,weight选项，左边小于右边
function add_ahw(){
	
	var min_age = $("select[name='min_age']");
	var max_age = $("select[name='max_age']");
	var min_height = $("select[name='min_height']");
	var max_height = $("select[name='max_height']");
	var min_weight = $("select[name='min_weight']");
	var max_weight = $("select[name='max_weight']");
	for (let i = 18; i <= 99; i++) {
		min_age.append("<option value =" + i + ">" + i + "</option>");
		max_age.append("<option value =" + i + ">" + i + "</option>");
	}
	for (let i = 120; i <= 220; i++) {
		min_height.append("<option value =" + i + ">" + i + "</option>");
		max_height.append("<option value =" + i + ">" + i + "</option>");
	}
	for (let i = 30; i <= 99; i++) {
		min_weight.append("<option value =" + i + ">" + i + "</option>");
		max_weight.append("<option value =" + i + ">" + i + "</option>");
	}
	
	var form=layui.form;
	//age监听
	//改了最小值，处理最大值
	form.on('select(min_age)', function(data) {
		var minage=parseInt(data.value);
		var maxage=parseInt(max_age.val());
		max_age.html("");
		max_age.append("<option value =-1>不限</option>");
		var minopt=(minage==-1?18:(minage+1));
		for(let i=minopt;i<=99;i++){
			max_age.append("<option value =" + i + ">" + i + "</option>");
		}
		if(minage < maxage||minage==-1){
			max_age.val(maxage);
		}
		
		form.render();
	});
	//改了最大值，处理最小值
	form.on('select(max_age)', function(data) {
		var maxage=parseInt(data.value);
		var minage=parseInt(min_age.val());
		min_age.html("");
		min_age.append("<option value =-1>不限</option>");
		var maxopt=(maxage==-1?100:maxage);
		for(let i=18;i<maxopt;i++){
			min_age.append("<option value =" + i + ">" + i + "</option>");
		}
		if(maxage > minage || maxage==-1){
			min_age.val(minage);
		}
		form.render();
	});
	
	//height监听
	form.on('select(min_height)', function(data) {
		var minheight=parseInt(data.value);
		var maxheight=parseInt(max_height.val());
		max_height.html("");
		max_height.append("<option value =-1>不限</option>");
		var minopt=(minheight==-1?120:(minheight+1));
		for(let i=minopt;i<=220;i++){
			max_height.append("<option value =" + i + ">" + i + "</option>");
		}
		if(minheight < maxheight||minheight==-1){
			max_height.val(maxheight);
		}
		form.render();
	});
	form.on('select(max_height)', function(data) {
		var maxheight=parseInt(data.value);
		var minheight=parseInt(min_height.val());
		min_height.html("");
		min_height.append("<option value =-1>不限</option>");
		var maxopt=(maxheight==-1?221:maxheight);
		for(let i=120;i<maxopt;i++){
			min_height.append("<option value =" + i + ">" + i + "</option>");
		}
		if(maxheight > minheight || maxheight==-1){
			min_height.val(minheight);
		}
		form.render();
	});
	
	//weight监听
	form.on('select(min_weight)', function(data) {
		var minweight=parseInt(data.value);
		var maxweight=parseInt(max_weight.val());
		max_weight.html("");
		max_weight.append("<option value =-1>不限</option>");
		var minopt=(minweight==-1?30:(minweight+1));
		for(let i=minopt;i<=99;i++){
			max_weight.append("<option value =" + i + ">" + i + "</option>");
		}
		if(minweight < maxweight||minweight==-1){
			max_weight.val(maxweight);
		}
		form.render();
	});
	form.on('select(max_weight)', function(data) {
		var maxweight=parseInt(data.value);
		var minweight=parseInt(min_weight.val());
		min_weight.html("");
		min_weight.append("<option value =-1>不限</option>");
		var maxopt=(maxweight==-1?100:maxweight);
		for(let i=30;i<maxopt;i++){
			min_weight.append("<option value =" + i + ">" + i + "</option>");
		}
		if(maxweight > minweight || maxweight==-1){
			min_weight.val(minweight);
		}
		form.render();
	});
	
}



//地区手动回填obj.job_addr
function areaval(obj){
	var province = obj.substring(0,2)+"0000";
	var city = obj.substring(0,4)+"00";
	var county = obj;
	//地区手动触发
	$('#province-1+.layui-form-select>.layui-anim>dd[lay-value="'+province+'"]').click();
	$('#city-1+.layui-form-select>.layui-anim>dd[lay-value="'+city+'"]').click();
	$('#county-1+.layui-form-select>.layui-anim>dd[lay-value="'+county+'"]').click();
	
}
//填带有不限的地区
function unconfinearea(obj){
	if(obj==-1)return;
	var province=city=county=-1;
	if(areaList.province_list[obj]){
		province=obj;
	}else if(areaList.city_list[obj]){
		province = obj.substring(0,2)+"0000";
		city=obj;
	}else{
		province = obj.substring(0,2)+"0000";
		city = obj.substring(0,4)+"00";
		county = obj;
	}
	//地区手动触发
	$('#province-1+.layui-form-select>.layui-anim>dd[lay-value="'+province+'"]').click();
	$('#city-1+.layui-form-select>.layui-anim>dd[lay-value="'+city+'"]').click();
	$('#county-1+.layui-form-select>.layui-anim>dd[lay-value="'+county+'"]').click();
	
	
}
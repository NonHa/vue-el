var $ = layui.$;
//配置插件目录
layui.config({
	base: '../js/',
	version: '1.0'
});
//侧边栏

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
	layarea.render({
		elem: '#area-picker2',
		change: function(res) {
			//选择结果
			console.log(res);
		}
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
		if(maxage == -1 || minage > maxage){
			max_age.html("");
			max_age.append("<option value =-1>不限</option>");
			for(let i=minage+1;i<99;i++){
				max_age.append("<option value =" + i + ">" + i + "</option>");
			}
		}
		form.render();
	});
	//改了最大值，处理最小值
	form.on('select(max_age)', function(data) {
		var maxage=parseInt(data.value);
		var minage=parseInt(min_age.val());
		if(minage == -1 || maxage < minage){
			min_age.html("");
			min_age.append("<option value =-1>不限</option>");
			for(let i=18;i<maxage;i++){
				min_age.append("<option value =" + i + ">" + i + "</option>");
			}
		}
		form.render();
	});
	
	//height监听
	form.on('select(min_height)', function(data) {
		var minheight=parseInt(data.value);
		var maxheight=parseInt(max_height.val());
		if(maxheight == -1 || minheight > maxheight){
			max_height.html("");
			max_height.append("<option value =-1>不限</option>");
			for(let i=minheight+1;i<220;i++){
				max_height.append("<option value =" + i + ">" + i + "</option>");
			}
		}
		form.render();
	});
	form.on('select(max_height)', function(data) {
		var maxheight=parseInt(data.value);
		var minheight=parseInt(min_height.val());
		if(minheight == -1 || minheight < maxheight){
			min_height.html("");
			min_height.append("<option value =-1>不限</option>");
			for(let i=120;i<maxheight;i++){
				min_height.append("<option value =" + i + ">" + i + "</option>");
			}
		}
		form.render();
	});
	
	//weight监听
	form.on('select(min_weight)', function(data) {
		var minweight=parseInt(data.value);
		var maxweight=parseInt(max_weight.val());
		if(maxweight == -1 || minweight > maxweight){
			max_weight.html("");
			max_weight.append("<option value =-1>不限</option>");
			for(let i=minweight+1;i<99;i++){
				max_weight.append("<option value =" + i + ">" + i + "</option>");
			}
		}
		form.render();
	});
	form.on('select(max_weight)', function(data) {
		var maxweight=parseInt(data.value);
		var minweight=parseInt(min_weight.val());
		if(minweight == -1 || minweight<maxweight){
			min_weight.html("");
			min_weight.append("<option value =-1>不限</option>");
			for(let i=30;i<maxweight;i++){
				min_weight.append("<option value =" + i + ">" + i + "</option>");
			}
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
//地区手动回填obj.job_addr
function areaval2(obj){
	var province = obj.substring(0,2)+"0000";
	var city = obj.substring(0,4)+"00";
	var county = obj;
	//地区手动触发
	$('#province-2+.layui-form-select>.layui-anim>dd[lay-value="'+province+'"]').click();
	$('#city-2+.layui-form-select>.layui-anim>dd[lay-value="'+city+'"]').click();
	$('#county-2+.layui-form-select>.layui-anim>dd[lay-value="'+county+'"]').click();
	
}
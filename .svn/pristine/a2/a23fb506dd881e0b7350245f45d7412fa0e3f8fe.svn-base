var user_id = 0;
var $=layui.$;
var form=layui.form,
flow=layui.flow;	

$(document).ready(function(){
 	var data={
 		"operate":"getBasicInfo"
 	};
 	Ajax(ajax_getFans,data);
	
 });
 
function ajax_addImg(obj){
	if(obj.Code>0)alert(obj.Msg);
	else {
		var ary = JSON.parse(obj.Result); 
		console.log("上传成功");
	}
}
function ajax_getFans(obj){
	if(obj.Code>0)alert(obj.Msg);
	else {
		var ary = JSON.parse(obj.Result); 
		session = obj.session;
		user_id = session.userid;
		checkLogin();
		if(ary.user.photo){
			$("img[name='touxiang']").attr("src",decodeURIComponent(ary.user.photo));
		}
		$("#nickname2").html(decodeURIComponent(session.nickname));
		$("input[name='sex'][value="+session.sex+"]").attr("checked",true); 
		$("#tel").html(session.tel);
		// form.val("baseinfo",ary.user);
		//相片加载
		for(let i = 0; i < ary.img_url.length; i++){
			var imgurl=decodeURIComponent(ary.img_url[i].url);
			if(imgurl!=""&& ary.img_url[i].lab=="album"){
				$("#album").append('<li  style="margin:0 10px; display:inline-block !important; display:inline;  max-width:200px; max-height:200px;">' +
				'<img onclick="del_photo(this)" id="' + ary.img_url[i].id + '" class="showimg"  style="width: 100%;height: 100%" src="' + imgurl + '"></li>');
			}
		}
		IconUpload(user_id);
	};
}

function del_photo(obj){
	var id=$(obj).attr("id");
	layer.open({
		content:"是否删除照片？",
		btn:['确认','取消'],
		btn1: function(){
			layer.closeAll();
			let de={"operate":"delImg","id":id};
			Ajax(del_return,de);
			$(obj).remove();
			window.location.reload();
		}
	})
}
function del_return(obj){
	if(obj.Code>0)alert(obj.Msg);
	else {
		var ary = JSON.parse(obj.Result); 
		layer.msg('删除成功', {
		  time: 0//不自动关闭
		  ,btn: ['确定']
		  ,yes: function(index){
		    layer.close(index);
		  }
		});
	}
}

function exit(){
	layer.open({
		content:"是否退出登录？",
		btn:['确认','取消'],
		btn1: function(){
			layer.closeAll();
			let data = {"operate":"exitWeb"};
			Ajax(ajax_edit, data);
		}
	})
}
function  ajax_edit(obj){
	if(obj.Code>0)alert(obj.Msg);
	else { 
		window.location.href="../../index.html"; //在原有窗口打开
		$("#nickname").html("未登录");
		$("#nickname").html("登录");
		$("#modal-986430").show();
		$("#nickname").hide();
	}
}
function basesubmit(){
	form.on('submit(basesubmit)',function(data){
		//表单验证
		
		data.field.operate="updateUser";
		Ajax(function(obj){
			if(obj.Code>0)alert(obj.Msg);
			else {
				layer.alert('提交成功', {
				  icon: 1,
				  skin: 'layer-ext-moon'
				})   
				window.location.reload();
			}
		},data.field);
		return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
	})
}

		
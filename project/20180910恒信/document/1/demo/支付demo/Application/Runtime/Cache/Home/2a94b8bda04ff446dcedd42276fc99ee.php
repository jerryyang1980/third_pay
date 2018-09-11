<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>测试</title>
</head>

<body>
金额：<input type="text" name="money" id="money" value="" />
<p>支付方式 1-微信  2-支付宝</p>
支付方式：<input type="text" name="type" id="type" value="1" />
</br>
</br>
<input type="button" value="提交" onclick="sumbit()" />
</br>
</br>
<div id="qrcode"></div>
</br>
</br>
<div id="zfb_h5"><a href="javascript:void(0);" onclick="applink()">H5打开-支付宝</a></div>

<input type="hidden" name="ali_call_url" id="ali_call_url"></input>

<script type="text/javascript" src="/Public/Home/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script type="text/javascript">

function applink(){
	var call_back_url =  $("#ali_call_url").val();
	if (call_back_url == '') {
		alert('只有支付宝能唤醒');
		return false;
	}
	console.log(call_back_url);
    window.location = call_back_url; 
        var clickedAt = +new Date; 
         setTimeout(function(){
             !window.document.webkitHidden && setTimeout(function(){
                   if (+new Date - clickedAt < 2000){ 
                       window.location = 'https://itunes.apple.com/us/app/zhe-jiang-yi-dong-shou-ji/id898243566#weixin.qq.com'; 
                   } 
             }, 500);      
         }, 500)  
 
}

function sumbit(){
	var money = $("#money").val();
	var type = $("#type").val();
	if(!money){
		alert('金额不能为空');
		return false;
	}
	$("#qrcode").empty();
	$("#ali_call_url").val('');
	if (type == 2) {
		$('#zfb_h5').show();
	}else{
		$('#zfb_h5').hide();
	}
	$.ajax({
		   type: "POST",
		   url: "<?php echo U('Index/doPostTest');?>",
		   data: {money:money,type:type},
		   success: function(data){
			   if(data.status == 1){
			   		var url = data.url;
			   		var call_back = data.call_back;
			   		if (call_back) {  // 支付宝h5
			   			$("#ali_call_url").val(call_back);
			   		}
			   		var qrcode = $('#qrcode').qrcode({  //生成二维码
			   			width: 128,
			   			height: 128,
			   			text: url
				  });
			   }else{
			   	alert(data.msg);
			   }
		   },
		   cache: false,
		   error:function(){
			  
		   }
		});
}
</script>
</body>
</html>
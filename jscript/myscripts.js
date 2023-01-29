$(document).ready(function() {
	"use strict";
	$('#button-pass-show-hide').click(function(){
		var statuspass = $('#button-pass-show-hide').attr("class");  
		if (statuspass === "pass-show"){
			$('#button-pass-show-hide').attr("class","pass-hide");       
			var $input = $("#auth_pass");
			var change = "text";
			var rep = $("<input placeholder='Şifrə' type='" + change + "'>")
			.attr("id", $input.attr("id"))
			.attr("name", $input.attr("name"))
			.attr('class', $input.attr('class'))
			.val($input.val())
			.insertBefore($input);
			$input.remove();
			$input = rep;        
		}
		else{
			$('#button-pass-show-hide').attr("class","pass-show");        
			var $inputps = $("#auth_pass");
			var changeps = "password";
			var repps = $("<input placeholder='Şifrə' type='" + changeps + "' />")
			.attr("id", $inputps.attr("id"))
			.attr("name", $inputps.attr("name"))
			.attr('class', $inputps.attr('class'))
			.val($inputps.val())
			.insertBefore($inputps);
			$inputps.remove();
			$inputps = repps;  
		}
	});
	$('#remindpass').click(function(){    
		$('#logincol').fadeOut(200, function(){  
			$('#block-remind').fadeIn(300);
		});
	});
	$('#prev-auth').click(function(){    
		$('#block-remind').fadeOut(200, function() {  
			$('#logincol').fadeIn(300);
		});
	});
	$('#button-remind').click(function(){    
		var recall_email = $("#remind-email").val(); 
		if(recall_email === "" || recall_email.length > 30){
			$("#remind-email").css("borderColor","#FDB6B6");
		}
		else{
			$("#remind-email").css("borderColor","#DBDBDB");   
			$("#button-remind").hide();
			$(".auth-loading").show();    
			$.ajax({
				type: "POST",
				url: "../myblocks/remind-pass.php",
				data: "email="+recall_email,
				dataType: "html",
				cache: false,
				success: function(data){
					if(data === 'yes'){
						$(".auth-loading").hide();
						$("#button-remind").show();
						$('#message-remind').attr("class","message-remind-success").html("Sizin e-mail ünvana şifrə göndərildi.").slideDown(400);     
						setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#logincol').show()", 3000); 
					}
					else{
						$(".auth-loading").hide();
						$("#button-remind").show();
						$('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);      
					}
				}
			}); 
		}
	});
	$('#reloadcaptcha').click(function(){
		$('#block-captcha > img').attr("src","../reg/reg_captcha.php?r="+ Math.random());
	});
	$(function(){
		$("#typepers").change(function(){
			if($("#typepers option:selected").val() === "Hüquqi şəxs"){
				$(".companyhide").addClass("companyshow");
				$(".citizenhide").removeClass("citizenshow");
			}
			else{
				$(".companyhide").removeClass("companyshow");
				$(".citizenhide").addClass("citizenshow");
			}
		});
	});
	$("#button-auth").click(function(){        
		var auth_login = $("#auth_login").val();
		var auth_pass = $("#auth_pass").val(); 
		var send_login;
		var send_pass;
		var auth_rememberme;
		if(auth_login === "" || auth_login.length > 10){
			$("#auth_login").css("borderColor","#FDB6B6");
			send_login = 'no';
		}
		else{    
			$("#auth_login").css("borderColor","#DBDBDB");
			send_login = 'yes'; 
		} 
		if(auth_pass === "" || auth_pass.length > 12){
			$("#auth_pass").css("borderColor","#FDB6B6");
			send_pass = 'no';
		}
		else{
			$("#auth_pass").css("borderColor","#DBDBDB");
			send_pass = 'yes';
		}
		if($("#rememberme").prop('checked')){
			auth_rememberme = 'yes';
		}
		else{
			auth_rememberme = 'no';
		}
		if(send_login === 'yes' && send_pass === 'yes'){ 
			$("#button-auth").hide();
			$(".auth-loading").show();    
			$.ajax({
				type: "POST",
				url: "../myblocks/auth.php",
				data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
				dataType: "html",
				cache: false,
				success: function(data){
					if(data === 'yes_auth'){
						location.reload();
					}
					else{
						$("#message-auth").slideDown(400);
						$(".auth-loading").hide();
						$("#button-auth").show();      
					}  
				}
			});  
		}
	});
	$('#logout').click(function(){    
    	$.ajax({
  			type: "POST",
  			url: "../myblocks/logout.php",
  			dataType: "html",
  			cache: false,
  			success: function(data){
  				if(data === 'logout'){
					location.reload();
				}  
			}
		}); 
	});
	$(function(){
		$("#pledge_exist").change(function(){
	if($("#pledge_exist option:selected").val() === "bəli"){
		$(".show-hide").show();
	}
	else{
		$(".show-hide").hide();
	}
			});});
});
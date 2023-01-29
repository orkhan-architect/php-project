$(document).ready(function(){
	"use strict";
	$('#form_reg').validate({
		rules:{
			"form_famstatus":{
				required:true,
			},
			"form_membercount":{
				required:true,
			},
			"form_collabcount":{
				required:true,
			},
			"form_allprofit":{
				required:true,
			},
			"form_allexpense":{
				required:true,
			},
			"form_cooperation":{
				required:true,
				minlength:4,
				maxlength:30
			},
			"form_experience":{
				required:true,
			},
			"form_myprofit":{
				required:true,
			},
			"form_recommend":{
				required:true,
				minlength:3,
				maxlength:30
			},
			"form_finance":{
				required:true,
			},
			"form_otherfin":{
				required:true,
			},
			"form_credaim":{
				required:true,
				minlength:6,
				maxlength:30
			},
			"form_creproduct":{
				required:true,
			},
			"form_amount":{
				required:true,
			},
			"form_credcur":{
				required:true,
			},
			"form_period":{
				required:true,
			},
			"form_exst":{
				required:true,
			},
			"form_pledgetype":{
				required:true,
			},
			"form_pledvalue":{
				required:true,
			},
			"form_pledcur":{
				required:true,
			},
			"form_pledinfo":{
				required:true
			},
			"form_cruser":{
				required:true
			},
			"acbagr":{
				required:true
			},
			"jobdoc":{
				required:true
			},
			"captcha_code":{
				required:true,
				remote: {
					type: "post",    
					url: "../ord/check_captcha.php"		                    
				}                            
			}
		},					
		messages:{
			"form_famstatus":{
				required:"Evli və ya subay olmağınızı qeyd edin!",
			},
			"form_membercount":{
				required:"Siz daxil ailə üzvlərinizin sayını qeyd edin!",
			},
			"form_collabcount":{
				required:"Ailədə siz daxil işləyənlərin sayını qeyd edin!",                            
			},
			"form_allprofit":{
				required:"Ailənizin siz daxil ümumi aylıq gəlirini qeyd edin!",                            
			},
			"form_allexpense":{
				required:"Ailənizin siz daxil ümumi aylıq xərcini qeyd edin!",                            
			},
			"form_cooperation":{
				required:"İş yerinizi tam və dolğun formada qeyd edin!",
				minlength:"4-30 simvol arası!",
				maxlength:"4-30 simvol arası!"  
			},
			"form_experience":{
				required:"İş (fəaliyyət) təcrübənizi aylarla qeyd edin!",  
			},
			"form_myprofit":{
				required:"Orta aylıq qazancınızı, mənfəətinizi qeyd edin!",  
			},
			"form_recommend":{
				required:"Bizim bankı necə tapdınız",
				minlength:"3-30 simvol arası!",
				maxlength:"3-30 simvol arası!"  
			},
			"form_finance":{
				required:"Yükləyəcəyiniz əsas arayış növünü qeyd edin!",  
			},
			"form_otherfin":{
				required:"Yükləyəcəyiniz digər sənədləri qeyd edin!",  
			},
			"form_credaim":{
				required:"Kredit almaqda məqsədinizi qeyd edin!",
				minlength:"6-30 simvol arası!",
				maxlength:"6-30 simvol arası!"  
			},
			"form_creproduct":{
				required:"Seçdiyiniz kredit məhsulunu qeyd edin!",  
			},
			"form_amount":{
				required:"Məhsula uyğun kredit məbləğini qeyd edin!",  
			},
			"form_credcur":{
				required:"Məhsula uyğun kreditinizin valyutasını qeyd edin!",  
			},
			"form_period":{
				required:"Məhsula uyğun kreditin müddətini təyin edin!",  
			},
			"form_exst":{
				required:"Girovlu və ya girovsuz olmasını təyin edin!",  
			},
			"form_pledgetype":{
				required:"Təklif edəcəyiniz girov tipini seçin!",  
			},
			"form_pledvalue":{
				required:"Girovun hazırki bazar dəyərini qeyd edin!",  
			},
			"form_pledcur":{
				required:"Təklif edəcəyiniz girovun valyutasını qeyd edin!",
			},
			"form_pledinfo":{
				required:"Girovunuzu ətraflı xarakterizə edin!"
			},
			"form_cruser":{
				required:"Filial üzrə seçdiyiniz kredit əməkdaşımızı qeyd edin!"
			},
			"acbagr":{
				required:"AKB üzrə razılıq verməyiniz mütləqdir!"
			},
			"jobdoc":{
				required:"Əsas maliyyə arayışınızın hökumət portalı üzərindən əldə etməyimizə razılıq verməlisiniz!"
			},
			"captcha_code":{
				required:"Şəkildəki şifrəni daxil edin!",
				remote: "Düzgün yazılmadı!"
			}
		},					
		submitHandler: function(form){
			$(form).ajaxSubmit({
				success: function(data){								 
					if(data === 'true'){
						$("#block-form-registration").fadeOut(300,function(){        
        					$("#reg_message").addClass("reg_message_good").fadeIn(400).html("Sizin sifariş uğurla əməkdaşımıza göndərildi. Yükləmələr səhifəsinə daxil olub maliyyə sənədlərinizi göndərməklə sifarişi tamamlamağınızı rica edirik.");
							$("#form_submit").hide();
						});
					}
					else{
						$("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); 
					}
				} 
			}); 
		}
	});
});
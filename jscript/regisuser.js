$(document).ready(function(){
	"use strict";
	$('#form_reg').validate({
		rules:{
			"form_login":{
				required:true,
				minlength:7,
				maxlength:10,
				remote: {
					type: "post",    
					url: "../reg/check_login.php"
				}
			},
			"form_client":{
				required:true,
				minlength:3,
				maxlength:40
			},
			"form_lesscap":{
				required:true
			},
			"form_persontype":{
				required:true
			},
			"form_bosstype":{
				required:true,
				minlength:4,
				maxlength:30
			},
			"form_bossinit":{
				required:true,
				minlength:3,
				maxlength:40
			},
			"form_docserinum":{
				required:true,
				minlength:9,
				maxlength:11
			},
			"form_docgovername":{
				required:true,
				minlength:4,
				maxlength:20
			},
			"form_business":{
				required:true,
				minlength:3,
				maxlength:30
			},
			"form_sharhol":{
				required:true,
				minlength:5,
				maxlength:255
			},
			"form_sharport":{
				required:true,
				minlength:3,
				maxlength:50
			},
			"form_docredate":{
				required:true,
				minlength:10,
				maxlength:10
			},
			"form_bodate":{
				required:true,
				minlength:10,
				maxlength:10
			},
			"form_pasvor":{
				required:true,
				minlength:7,
				maxlength:12
			},
			"form_individ":{
				required:true,
				minlength:6,
				maxlength:10
			},
			"form_email":{
				required:true,
				email:true
			},
			"form_phonumb":{
				required:true
			},
			"form_verificatornum":{
				required:true,
				minlength:10,
				maxlength:10
			},
			"form_ladres":{
				required:true
			},
			"form_radres":{
				required:true
			},
			"form_branch":{
				required:true
			},
			"form_invalid":{
				required:true
			},
			"captcha_code":{
				required:true,
				remote: {
					type: "post",    
					url: "../reg/check_captcha.php"		                    
				}                           
			}
		},					
		messages:{
			"form_login":{
				required:"Logini qeyd edin!",
				minlength:"7-10 simvol arası!",
				maxlength:"7-10 simvol arası!",
				remote: "Bu login mövcuddur!"
			},
			"form_persontype":{
				required:"Digər xanaların aktivləşməsi üçün ən birinci müştəri tipini seçin!"
			},
			"form_client":{
				required:"Soyad, ad, ata adınızı və ya şirkətin adını tam qeyd edin!",
				minlength:"3-40 simvol arası!",
				maxlength:"3-40 simvol arası!"
			},
			"form_lesscap":{
				required: "Aztəminatlılığınızı qeyd edin!"
			},
			"form_bosstype":{
				required:"İdarəedicinin vəzifəsini qeyd edin!",
				minlength:"4-30 simvol arası!",
				maxlength:"4-30 simvol arası!"                            
			},
			"form_bossinit":{
				required:"Adınızı qeyd edin!",
				minlength:"3-40 simvol arası!",
				maxlength:"3-40 simvol arası!"                               
			},
			"form_docserinum":{
				required:"Vəsiqənizin seriya və kodunu qeyd edin!",
				minlength:"9-11 simvol arası!",
				maxlength:"9-11 simvol arası!"  
			},
			"form_docgovername":{
				required:"Vəsiqəni verən orqanı qeyd edin!",
				minlength:"4-20 simvol arası!",
				maxlength:"4-20 simvol arası!"  
			},
			"form_business":{
				required:"Fəaliyyət sferanızı qeyd edin!",
				minlength:"3-30 simvol arası!",
				maxlength:"3-30 simvol arası!"  
			},
			"form_sharhol":{
				required:"Təsisçiləri vergül qoyaraq qeyd edin!",
				minlength:"5-255 simvol arası!",
				maxlength:"5-255 simvol arası!"  
			},
			"form_sharport":{
				required:"Təsisçi paylarını vergül qoyaraq qeyd edin!",
				minlength:"3-50 simvol arası!",
				maxlength:"3-50 simvol arası!"  
			},
			"form_docredate":{
				required:"Vəsiqənizin qeydiyyat tarixini qeyd edin!",
				minlength:"10 simvol olmalıdır!",
				maxlength:"10 simvol olmalıdır!"  
			},
			"form_bodate":{
				required:"Doğum tarixinizi qeyd edin!",
				minlength:"10 simvol olmalıdır!",
				maxlength:"10 simvol olmalıdır!"  
			},
			"form_individ":{
				required:"Sahibkar VÖENinizi qeyd edin və ya sahibkar deyilsizsə, yoxdur yazın!",
				minlength:"6 simvol olmalıdır!",
				maxlength:"10 simvol olmalıdır!"  
			},
			"form_pasvor":{
				required:"Şifrəni qeyd edin!",
				minlength:"7-12 simvol arası olmalıdır!",
				maxlength:"7-12 simvol arası olmalıdır!"  
			},
			"form_email":{
				required:"E-mail ünvanınızı qeyd edin",
				email:"E-mail düzgün deyil"
			},
			"form_phonumb":{
				required:"Telefon nömrələrinizi qeyd edin!"
			},
			"form_verificatornum":{
				required:"Təsdiqləyici mobil nömrənizi qeyd edin!",
				minlength:"minimum 10 simvol olmalıdır!",
				maxlength:"maximum 10 simvol olmalıdır!"
			},
			"form_ladres":{
				required:"Yaşadığınız ünvanı qeyd edin!"
			},
			"form_radres":{
				required:"Vəsiqə üzrə rəsmi qeydiyyat ünvanınızı qeyd edin!"
			},
			"form_branch":{
				required: "Qeydiyyat üçün filial qeyd edin!"
			},
			"form_invalid":{
				required: "Əlilliyinizi qeyd edin!"
			},
			"captcha_code":{
				required:"Şəkildəki şifrəni düzgün daxil edin!",
				remote: "Düzgün yazılmadı!"
			}
		},					
		submitHandler: function(form){
			$(form).ajaxSubmit({
				success: function(data){								 
					if(data === 'true'){
						$("#block-form-registration").fadeOut(300,function(){        
        					$("#reg_message").addClass("reg_message_good").fadeIn(400).html("Siz uğurla qeydiyyatdan keçdiniz. Məlumatlarınız əməkdaşlarımız tərəfindən qısa zaman ərzində yoxlanılacaqdır. Əgər şübhəli hal aşkar edilməzsə, profilinizi təsdiq edən şifrə qısa zamanda email ünvanınıza və ya təsdiqləyici mobil nömrənizə göndəriləcək. Bundan sonra profiliniz aktivləşəcək və kredit sifarişlərinizi göndərə biləcəksiniz. Bizi seçdiyiniz üçün təşəkkür edirik!");
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
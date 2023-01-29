$(document).ready(function(){
	"use strict";
	$('#genpass').click(function(){
 		$.ajax({
  			type: "POST",
  			url: "../inc_blocks/genpass.php",
  			dataType: "html",
  			cache: false,
  			success: function(data){
  				$('#reg_pass').val(data);
  			}
		});
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
	$(function(){
		$("#typepled").change(function(){
			if($("#typepled option:selected").val() === "minik avtomobili" || $("#typepled option:selected").val() === "yük avtomobili" || $("#typepled option:selected").val() === "kənd təsərrüfatı texnikası" || $("#typepled option:selected").val() === "tikinti sektoru texnikası"){
				$(".vehiclehide").addClass("vehicleshow");
				$(".apraisinsurhide").addClass("apraisinsurshow");
				$(".flathide").removeClass("flatshow");
			}
		});
	});
	$(function(){
		$("#typepled").change(function(){
			var selectpledge = $("#typepled option:selected").val();
			if(selectpledge === "torpaq sahəsi" || selectpledge === "əmlak kompleksi" || selectpledge === "qeyri-yaşayış sahəsi" || selectpledge === "fərdi yaşayış evi" || selectpledge === "bağ evi" || selectpledge === "mənzil"){
				$(".flathide").addClass("flatshow");
				$(".apraisinsurhide").addClass("apraisinsurshow");
				$(".vehiclehide").removeClass("vehicleshow");
			}
		});
	});
	$(function(){
		$("#typepled").change(function(){
			var selectpledge = $("#typepled option:selected").val();
			if(selectpledge === "əmanət hesabı vəsaiti" || selectpledge === "cari hesabdakı vəsait" || selectpledge === "qiymətli metal" || selectpledge === "zinət əşyası" || selectpledge === "dövriyyədəki mal" || selectpledge === "avadanlıq" || selectpledge === "qiymətli kağız" || selectpledge === "zəmanət"){
				$(".flathide").removeClass("flatshow");
				$(".vehiclehide").removeClass("vehicleshow");
				$(".apraisinsurhide").removeClass("apraisinsurshow");
			}
		});
	});
	$(function(){
		$("#pledge_exist").change(function(){
	if($("#pledge_exist option:selected").val() === "girovlu"){
		$(".show-hide").show();
	}
	else{
		$(".show-hide").hide();
	}
			});});
});
/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

$(document).ready(function() {
	$("#activate_submit").click(function(){
		var send_pass = $('#activate_submit').hasClass("send_pass");
		if (!send_pass) {
			var pass_erro = '0';
		} else {
			var pass_erro = '1';
		}
		$.ajax({
			type : "POST",
			url : popup_sc_front_controller_dir,
			dataType: "json",
			data : {
				ajax : true,
				email : $("[name='email']").val(),
				password : $("[name='password']").val(),
				activate : $("[name='activate']").val(),
				user_data_id : $("[name='user_data_id']").val(),
				user_fname : $("[name='user_fname']").val(),
				user_lname : $("[name='user_lname']").val(),
				screen_name : $("[name='screen_name']").val(),
				gender : $("[name='gender']").val(),
				popup : $("[name='popup']").val(),
				pass_erro : pass_erro,
			},
			beforeSend: function(){
				loaderOpening();
			},
			success : function(response){
				if(Object.keys(response.errors).length > 0){
					loaderClose();
					if(response.errors.fname){
						$.growl.error({ title: "", message:response.errors.fname});
					}
					if(response.errors.lname){
						$.growl.error({ title: "", message:response.errors.lname});
					}
					if(response.errors.email){
						$.growl.error({ title: "", message:response.errors.email});
					}
					if(response.errors.password){
						$.growl.error({ title: "", message:response.errors.password});
					}
					if(response.errors.email_exists){
						$.growl.error({ title: "", message:response.errors.email_exists});
					}
					if (response.have_email) {
						if (!send_pass) {
							$('.link_my_account').removeClass('hide');
						} else {
							$('.link_my_account').addClass('hide');
						}
					}
				} else {
					window.onunload = refreshParent();
					function refreshParent() {
						if(pn_social_redirect == "no_redirect") {
							if(response.popup) {
								window.opener.location.reload();
							} else {
								window.location.href = baseDir ;
							}
						} else {
							if(response.popup) {
								window.opener.location.href = my_account_url;
							} else {
								window.location.href = my_account_url;
							}
						}
					}
					if(response.popup) {
						setTimeout(function(){
							self.close();
						}, 500)
					}
				}
			}
		});
		return false;
	});

	$("#link_my_account").click(function(){
		$('.fname, .lname, .link_my_account').addClass('hide');
		$('.hidden_pass').removeClass('hide');
		$('.sc_back').removeClass('hide');
		$('#activate_submit').addClass('send_pass');
		return false;
	});
	$(".sc_back").click(function(){
		$('.fname, .lname').removeClass('hide');
		$('.hidden_pass, .sc_back').addClass('hide');
		$('#activate_submit').removeClass('send_pass');
		return false;
	});
});

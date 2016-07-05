<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.7.2.min.js');?>
<h3><b>Change your password</b></h3>
<form id="change_pass_frm">
<table>
<tr height="40">
<td width="120">
<b>Password</b>
</td>
<td>
<input type="password" id="password" name="password" size="40">
<div id="password_error"></div>
</td>
</tr>
<tr height="40">
<td>
<b>Confirm Password</b>
</td>
<td>
<input type="password" id="confirm_password" name="confirm_password"  size="40">
<div id="confirm_password_error"></div>
</td>
</tr>

<tr height="40">
<td>
</td>
<td>
<input type="button" id="upddate_password" name="upddate_password" value="Update Password" onClick="changePassword()">
</td>
</tr>

<tr>
<td>
</td>
<td>
<div id="change_pass_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="change_pass_info_div" class="form_info_div"></div><br><br>
<div class="login_text" id="login_text"></div><br>
<a href="<?php echo Yii::app()->controller->createUrl('site/login');?>" id="change_pass_login" class="change_pass_login">Login</a>
</td>
</tr>

</table>
</form>
<script language="javascript" type="text/javascript">
function changePassword()
{
	var password =$("#password").val();
	var confirm_password=$("#confirm_password").val();
	if(password!=""){
		$("#password_error").removeClass('error').html("").hide();
		if(confirm_password!=""){
			$("#confirm_password_error").removeClass('error').html("").hide();
			if(confirm_password==password){
				$("#password_error").removeClass('error').html("").hide();
				$("#confirm_password_error").removeClass('error').html("").hide();
					$.ajax({ 
					url: "<?php echo Yii::app()->controller->createUrl('Systemusers/changepassword');?>",
					type: "POST",
					data: {'password' : password},
					beforeSend: function(){
						$("#change_pass_preloader_div").fadeIn(200);
					}
					}).done(function(html){
						 if(parseInt(html)==2){
							 $("#login_text").hide().html('');
							 $("#change_pass_login").hide();
							$("#change_pass_info_div").removeClass('success').addClass('error').html('Password has previously been used.').show();
						}else if(parseInt(html)==0){
							$("#login_text").hide().html('');
							 $("#change_pass_login").hide();
							$("#change_pass_info_div").removeClass('success').addClass('error').html('An error occured while updating your password please try again.').show();
						}else{
							$('#change_pass_frm')[0].reset();
							$("#change_pass_login").show();
							
							$("#login_text").show().html('Please click on the link below to login.');
							$("#change_pass_info_div").removeClass('error').addClass('success').html('Password successfully updated.').show();
						}
						$("#change_pass_preloader_div").fadeOut(200);
					});	
			}else{
				$("#password_error").addClass('error').html("Passwords do not match.").show();
				$("#confirm_password_error").addClass('error').html("Passwords do not match.").show();
			}
		}else{
			$("#confirm_password_error").addClass('error').html("Please confirm your password.").show();
		}
	}else{
		$("#password_error").addClass('error').html("Please enter your password.").show();
	}
}

$(document).keypress(function(e) {
if(e.which == 13) {
	changePassword();
}
});	
</script>
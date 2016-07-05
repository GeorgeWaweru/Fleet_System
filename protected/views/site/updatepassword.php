<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.7.2.min.js');?>

<?php
$token=isset($_REQUEST['token']) ? base64_decode($_REQUEST['token']):"";
$token_params=explode('(##)',$token);
$reset_type=intval($token_params[0]);
$password_token=$token_params[1];
if($reset_type>0 && !empty($password_token))
{
$model=new Systemusers();
$validateToken=$model->validateToken($reset_type,$password_token);
	if($validateToken==1){
	?>
	<h3><b>Update your password</b></h3>
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
	
	
	<tr>
	<td>
	</td>
	<td>
	<div id="change_pass_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
	<div id="change_pass_info_div" class="form_info_div"></div><br>
	</td>
	</tr>
	
	
	<tr height="40">
	<td>
	</td>
	<td>
    <input type="hidden" id="form_token" name="form_token" value="<?php echo $password_token;?>" size="40">
	<input type="button" id="upddate_password" name="upddate_password" value="Update Password" onClick="updatePassword()">
    <br><br>
    <div id="frm_info_div"></div>
    <br>
    <div class="password_change_text" id="password_change_text"></div>
    <br>
	<a href="<?php echo Yii::app()->controller->createUrl('site/login');?>" id="change_pass_login" class="change_pass_login">Login</a>
    
    
    <a href="<?php echo Yii::app()->controller->createUrl('site/login');?>" id="change_pass_login" class="change_pass_login">Login</a>
	</td>
	</tr>
	</table>
	</form>
   
	<script language="javascript" type="text/javascript">
	function updatePassword()
	{
		var password =$("#password").val();
		var confirm_password=$("#confirm_password").val();
		var form_token=$("#form_token").val();
		if(password!=""){
			$("#password_error").removeClass('error').html("").hide();
			if(confirm_password!=""){
				$("#confirm_password_error").removeClass('error').html("").hide();
				if(confirm_password==password){
					$("#password_error").removeClass('error').html("").hide();
					$("#confirm_password_error").removeClass('error').html("").hide();
						$.ajax({ 
						url: "<?php echo Yii::app()->controller->createUrl('Systemusers/updatepassword');?>",
						type: "POST",
						data: {'password' : password,'confirm_password':confirm_password,'form_token':form_token},
						beforeSend: function(){
							$("#change_pass_preloader_div").fadeIn(200);
						}
						}).done(function(html){
							if(parseInt(html)==2){
								$("#frm_info_div").addClass('error').removeClass('success').html('Invalid password token.').show();
								$("#password_change_text").hide().html("");
								$("#change_pass_login").hide();
							}else if(parseInt(html)==3){
								$("#frm_info_div").removeClass('error').removeClass('success').html('').hide();
								$("#password_error").addClass('error').html("Passwords do not match.").show();
								$("#confirm_password_error").addClass('error').html("Passwords do not match.").show();
							}else{
								$("#form_token").val('');
								$('#change_pass_frm')[0].reset();
								$("#frm_info_div").addClass('success').removeClass('error').html('You have successfully changed your password.');
								$("#password_change_text").show().html("Click on the link below to login");
								$("#change_pass_login").show();
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
		updatePassword();
	}
	});	
	</script>
    
	 <?php
	}else{
	?>
	<div class="error">Invalid password token.</div>
	<?php
	}
}
?>
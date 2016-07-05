<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.7.2.min.js');?>
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="admin_login" style="margin: 0 auto;width: 40%;">
<h3>Administrator Login</h3>
<div class="form">

<form autocomplete="off">
<table>
<tr>
<td>
<b>Email</b>
</td>
<td>
<input name="email" id="email" type="text" size="40" />
<div id="email_error" class="loginerrordivs"></div>
</td>
</tr>

<tr>
<td>
<b>Password</b>
</td>
<td>
<input name="password" id="password" type="password" size="40" />
<div id="password_error" class="loginerrordivs"></div>
</td>
</tr>

<tr>
<td>
</td>
<td>
<div id="preloader_login_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="loggin_error_div"></div>
</td>
</tr>

<tr>
<td>
</td>
<td>
<input name="login" id="login" type="button" value="Login" onclick="LoginUser()" />&nbsp;&nbsp;
<a href="javascript:void(0);" id="forget_pass_btn">Forgot password?</a>
</td>
</tr>


<tr class="forgot_pass_div">
<td>
<b>Email</b>
</td>
<td>
<input name="forgot_email" id="forgot_email" type="text" size="40" />
<div id="preloader_forgot_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="forgot_email_error" class="forgetpasserrordivs"></div>
</td>
</tr>

<tr class="forgot_pass_div">
<td>
</td>
<td>
<input name="reset_password" id="reset_password" type="button" value="Reset Password" onclick="ResetPassword()" />&nbsp;&nbsp;
</td>
</tr>
</table>
</form>
	<br><br>



<script language="javascript" type="text/javascript">
$("#forget_pass_btn").click(function(){
	$(".forgot_pass_div").toggle();
	$("#email").val('');
	$("#password").val('');
	$(".loginerrordivs").removeClass('error').removeClass('success').html("").hide();
	$(".forgetpasserrordivs").removeClass('error').removeClass('success').html("").hide();
});

function ResetPassword()
{	
	$(".loginerrordivs").removeClass('error').html("").hide();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	var forgot_email=$("#forgot_email").val();
	if(emailReg.test(forgot_email) && forgot_email!=""){
		$("#forgot_email_error").html("").hide();
		$.ajax({ 
			url: "<?php echo Yii::app()->controller->createUrl('Systemusers/resetpassword');?>",
			type: "POST",
			data: {'email' : forgot_email},
			beforeSend: function(){
				$("#preloader_forgot_div").show();
			}
			}).done(function(html){
				$("#preloader_forgot_div").fadeOut('700');
				if(parseInt(html)==0){
					$("#forgot_email_error").addClass('error').removeClass('success').html("The email you entered does not exist in our database.").show();
				}else{
					$("#forgot_email_error").addClass('success').removeClass('error').html("An email has been sent to the email provided.").show();
					$("#forgot_email").val('');
				}
			});			
	}else{
		$("#forgot_email_error").addClass('error').html("Please enter a valid email address.").show();
	}
}




function LoginUser(){
	$(".forgot_pass_div").fadeOut(100);
	$(".forgetpasserrordivs").removeClass('error').html("").hide();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	var email=$("#email").val();
	var password=$("#password").val();
	if(emailReg.test(email) && email!=""){
		$("#email_error").removeClass('error').html("").hide();
			if(password!=""){
			$("#password_error").removeClass('error').html("").hide();
			$.ajax({ 
			url: "<?php echo Yii::app()->controller->createUrl('Systemusers/userlogin');?>",
			type: "POST",
			data: {'email' : email,'password' : password},
			beforeSend: function(){
				$("#preloader_login_div").show();
			}
			}).done(function(html){
				$("#preloader_login_div").fadeOut('700');
				var USER_DETAILS = jQuery.parseJSON(html);
				
				if(parseInt(USER_DETAILS.SUCCESSFUL_LOGIN)==1){
					if(parseInt(USER_DETAILS.USER_CHANGED_PASSWORD)==0){
						window.location="<?php echo Yii::app()->controller->createUrl('Site/Changepassword');?>";
					}else{
						if(USER_DETAILS.LOGGIN_USER=="admin_user"){
							window.location="<?php echo Yii::app()->controller->createUrl('Industries/admin');?>";
						}else if(USER_DETAILS.LOGGIN_USER=="company_user"){
							window.location="<?php echo Yii::app()->controller->createUrl('Users/admin');?>";
						}else if(USER_DETAILS.LOGGIN_USER=="company_sub_user"){
							
							if(USER_DETAILS.COMPANY_SUB_USER_ROLE=='Driver'){
								window.location="<?php echo Yii::app()->controller->createUrl('Requests/service');?>";
							}else if(USER_DETAILS.COMPANY_SUB_USER_ROLE=='TM'){
								window.location="<?php echo Yii::app()->controller->createUrl('Cars/admin');?>";
							}
						}else if(USER_DETAILS.LOGGIN_USER=="supplier"){
							window.location="<?php echo Yii::app()->controller->createUrl('Bookings/admin');?>";
						}
					}

				}else{
					$("#loggin_error_div").addClass('error').html("Wrong email and or password.").show();
				}
			});		
		}else{
			$("#password_error").addClass('error').html("Password cannot be blank.").show();
		}
	}else{
		$("#email_error").addClass('error').html("Please enter a valid email address").show();
	}
}

$(document).keypress(function(e) {
		if(e.which == 13) {
			if($(".forgot_pass_div").is(':visible')){
				ResetPassword();
			}else{
				LoginUser();
			}
			
		}
	});	
</script>
</div><!-- form -->
</div>

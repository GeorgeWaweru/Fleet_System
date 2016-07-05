<?php
$logged_role_level_session=isset($_SESSION['logged_role_level_session']) ? $_SESSION['logged_role_level_session']: "Low";
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'systemusers-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('autocomplete'=>'off'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

<table>

<tr height="30">
<td>
<b>User Role</b>
</td>
<td>
<?php echo $model->role->role_name; ?>
</td>
</tr>

<?php
if($logged_role_level_session=="Low"){
	?>
    
    <tr height="30">
<td>
<b>Country</b>
</td>
<td>
<?php echo $model->country->country_name; ?>
</td>
</tr>

<tr height="30">
<td>
<b>First Name</b>
</td>
<td>
<?php echo $model->first_name; ?>
</td>
</tr>


<tr height="30">
<td>
<b>Last Name</b>
</td>
<td>
<?php echo $model->last_name; ?>
</td>
</tr>


<tr height="30">
<td>
<b>Email</b>
</td>
<td>
<?php echo $model->email; ?>
</td>
<td>
<?php echo $form->error($model,'email'); ?>
</td>
</tr>

    <?php
}else if($logged_role_level_session=="High"){
	?>
    <tr height="30">
<td>
<b>Country</b>
</td>
<td>
<?php echo $model->country->country_name; ?>
</td>
<td>
<div id="country_error" class="errorMessage"></div>
</td>
</tr>

<tr height="30">
<td>
<b>First Name</b>
</td>
<td>
<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
</td>
<td>
<div id="first_name_error" class="errorMessage"></div>
</td>
</tr>


<tr height="30">
<td>
<b>Last Name</b>
</td>
<td>
<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
</td>
<td>
<div id="last_name_error" class="errorMessage"></div>
</td>
</tr>


<tr height="30">
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
</td>
<td>
<div id="email_error" class="errorMessage"></div>
</td>
</tr>

    <?php
}
?>


<tr height="30">
<td>
<b>Password</b>
</td>
<td>
<b>(8 characters long and a combination of uppercase and lowercase letters, numbers and symbols.)</b><br>
<?php echo CHtml::passwordField('password' , 'value', array('id' => 'password','onkeyup'=>'check(this.value)')); ?>
</td>
<td>
<div id="password_error" class="errorMessage"></div>
<span id="prog_bar"></span>
</td>
</tr>

<tr height="30">
<td>
<b>Confirm Password</b>
</td>
<td>
<?php echo CHtml::passwordField('confirm_password' , 'value', array('id' => 'confirm_password')); ?>
</td>
<td>
<div id="confirm_password_error" class="errorMessage"></div>
</td>
</tr>
<input name="hidden_user_id" id="hidden_user_id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ""; ?>" type="hidden" />
</table>
	
	<div class="row buttons">
		<input name="reset_pass" id="reset_pass" type="button" value="Reset Password" onclick="ResetPassword()" />
	</div>

<div id="success_info_div" class="success_info_div"></div>
<?php $this->endWidget(); ?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#password").val("");
	$("#confirm_password").val("");
});

function ResetPassword()
{
	var user_role_level="<?php echo $logged_role_level_session;?>";
	var password=$("#password").val();
	var confirm_password=$("#confirm_password").val();
	var hidden_user_id= $("#hidden_user_id").val();
	
	
	//var	Systemusers_country_id= $("#Systemusers_country_id").val();
	var	Systemusers_first_name= $("#Systemusers_first_name").val();
	var	Systemusers_last_name= $("#Systemusers_last_name").val();
	var	Systemusers_email= $("#Systemusers_email").val();
	
	if(user_role_level=="Low"){
		if(password!=""){
		   $("#password_error").html("").hide();
				if(confirm_password!=""){
						$("#confirm_password_error").html("").hide();
						
						if(confirm_password==password){
						$("#password_error").html("").hide();
						$("#confirm_password_error").html("").hide();
						
						
						
						$.ajax({ 
						url: "index.php?r=myaccount/Changepassword",
						type: "POST",
						data: {'password' : password,'hidden_user_id':hidden_user_id},
						beforeSend: function(){
						}
						}).done(function(html){
							$("#success_info_div").html("Password has been updated Succesfully").show();
							$("#password").val('');
							$("#confirm_password").val('');
						});		
	
	
				}else{
						$("#password_error").html("Passowrd do not match").show();
						$("#confirm_password_error").html("Passowrd do not match").show();
				}
						
				}else{
						$("#confirm_password_error").html("Confirm Passowrd cannot be blank").show();
				}
		}else{
				$("#password_error").html("Passowrd cannot be blank").show();
		}
	}else if(user_role_level=="High"){
		
		

			
				if(Systemusers_first_name!=""){
					$("#first_name_error").html("").hide();
					
						if(Systemusers_last_name!=""){
							$("#last_name_error").html("").hide();
							
							if(Systemusers_email!=""){
								$("#email_error").html("").hide();
								
								if(password!=""){
		  		 	$("#password_error").html("").hide();
				if(confirm_password!=""){
						$("#confirm_password_error").html("").hide();
						
						if(confirm_password==password){
						$("#password_error").html("").hide();
						$("#confirm_password_error").html("").hide();
						
						
						
						$.ajax({ 
						url: "index.php?r=myaccount/Changepassword",
						type: "POST",
						data: {
								'password' : password,
								'hidden_user_id':hidden_user_id,
								'Systemusers_first_name':Systemusers_first_name,
								'Systemusers_last_name':Systemusers_last_name,
								'Systemusers_email':Systemusers_email
						},
						beforeSend: function(){
						}
						}).done(function(html){
							$("#success_info_div").html("Password has been updated Succesfully").show();
							$("#password").val('');
							$("#confirm_password").val('');
						});		
	
	
				}else{
						$("#password_error").html("Passowrd do not match").show();
						$("#confirm_password_error").html("Passowrd do not match").show();
				}
						
				}else{
						$("#confirm_password_error").html("Confirm Passowrd cannot be blank").show();
				}
		}else{
				$("#password_error").html("Passowrd cannot be blank").show();
		}
							}else{
								$("#email_error").html("Please Enter your Email").show();
							}
						
						
						}else{
							$("#last_name_error").html("Please Enter your Last Name").show();
						}
				
				
				}else{
					$("#first_name_error").html("Please Enter your First Name").show();
				}
	}
}


</script>

</div><!-- form -->
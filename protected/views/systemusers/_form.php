<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php
$logged_role_level_session=isset($_SESSION['logged_role_level_session']) ? $_SESSION['logged_role_level_session']: "Low";
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'systemusers-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('autocomplete'=>'off'),
)); ?>
<?php
$task=$model->isNewRecord ? 1 : 0;
?>
<table>
<tr>
<td width="120">
<b>Role</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'role_id',CHtml::listData(Roles::model()->findAll(),'id','role_name') ,array('empty' => '--Select Role--')); ?>
<div id="role_error" class="errorMessage"></div>
</td>
</tr>
<tr>
<td>
<b>First Name</b>
</td>
<td>
<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
<div id="first_name_error" class="errorMessage"></div>
</td>
</tr>


<tr>
<td>
<b>Last Name</b>
</td>
<td>
<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
<div id="last_name_error" class="errorMessage"></div>
</td>
</tr>



<tr>
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
<div id="email_error" class="errorMessage"></div>
</td>
</tr>

<tr class="update_password">
<td></td>
<td>
<a href="javascript:void(0);" id="update_password_link">Update Password</a>
</td>
</tr>


<tr class="toggle_password_section" <?php echo $model->isNewRecord ? "" : "style='display:none'"; ?>">
<td>
<b>Password</b>
</td>
<td>
<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>
</td>
<td>
<div id="pass_error" class="errorMessage"></div>
</td>
</tr>


<tr class="toggle_password_section" <?php echo $model->isNewRecord ? "" : "style='display:none'"; ?>">
<td>
<b>Confirm Password</b>
</td>
<td>
<input size="50" maxlength="50" name="Systemusers[confirm_password]" id="Systemusers_confirm_password" type="password" /></td>
</td>
<td>
<div id="confirm_pass_error" class="errorMessage"></div>
</td>
</tr>


<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
</td>
<td>
<div id="status_error" class="errorMessage"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<div id="info_div" style="display:none;"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<div class="row buttons">
<input name="submit_button" id="submit_button" onclick="submitData()" value="<?php echo $model->isNewRecord ? 'Add' : 'Update'; ?>" type="button" />
</div>
</td>
</tr>
</table>
	
    
    



<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">

$("#update_password_link").click(function(){
	$(".toggle_password_section").toggle();
});


$(document).ready(function(){
	<?php
	if($task==1){
		?>
		$("#update_password_link").hide();
		$(".toggle_users").show();
		<?php
	}else{
		?>
		$(".toggle_users").hide();
		<?php
	}
	?>
	$("#Systemusers_password").val('');
});	
	
function submitData(){
var controller_action="<?php echo $model->isNewRecord ? 'create' : 'update'; ?>";
var id=<?php echo isset($_REQUEST['id']) ? $_REQUEST['id']:0; ?>;
if(controller_action=="update"){
	var action="update&id="+id;
}else{
	var action=controller_action;
}
var Systemusers_role_id=$("#Systemusers_role_id").val();	
var Systemusers_first_name=$("#Systemusers_first_name").val();	
var Systemusers_last_name=$("#Systemusers_last_name").val();
var Systemusers_email=$("#Systemusers_email").val();	
var Systemusers_password=$("#Systemusers_password").val();
var Systemusers_confirm_password=$("#Systemusers_confirm_password").val();
var Systemusers_status=$("#Systemusers_status").val();
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
if(Systemusers_role_id!=""){
	$("#role_error").html("").hide();
	if(Systemusers_first_name!=""){
		$("#first_name_error").html("").hide();
		if(Systemusers_last_name!=""){
			$("#last_name_error").html("").hide();
				if(emailReg.test(Systemusers_email) && Systemusers_email!=""){
				$("#email_error").html("").hide();
				if($('.toggle_password_section').is(':visible')){
					if(Systemusers_password!=""){
					$("#pass_error").html("").hide();
					if(Systemusers_confirm_password!=""){
						$("#confirm_pass_error").html("").hide();
						if(Systemusers_confirm_password==Systemusers_password){
							$("#pass_error").html("").hide();
							$("#confirm_pass_error").html("").hide();
								if(Systemusers_status!=""){
									$("#status_error").html("").hide();
									
									
											$.ajax({ 
											url: "index.php?r=Systemusers/"+action,
											type: "POST",
											data: {
											'Systemusers_role_id' : Systemusers_role_id,
											'Systemusers_first_name' : Systemusers_first_name,
											'Systemusers_last_name' : Systemusers_last_name,
											'Systemusers_email' : Systemusers_email,
											'Systemusers_password' : Systemusers_password,
											'Systemusers_status' : Systemusers_status
											},
											beforeSend: function(){
											}
											}).done(function(html){
												if(parseInt(html)==0){
													$("#info_div").html("An error Occured while saving the record").show();
												}else if(parseInt(html)==1){
													$("#email_error").html("The Email Address has been used before").show();
												}else if(parseInt(html)==2){
													$("#info_div").html("Enter all the fields").show();
												}else if(parseInt(html)==3){
													window.location="index.php?r=systemusers/admin";
												}
											});	
												
								//return false;	
								}else{
									$("#status_error").html("Status Cannot be Blank").show();
								}
						}else{
							$("#pass_error").html("Password Do not Match").show();
							$("#confirm_pass_error").html("Password Do not Match").show();
						}
					}else{
						$("#confirm_pass_error").html("Confirm Password Cannot be Blank").show();
					}
				}else{
					$("#pass_error").html("Password Cannot be Blank").show();
				}

				}else{
					
										$.ajax({ 
											url: "index.php?r=Systemusers/"+action,
											type: "POST",
											data: {
											'Systemusers_role_id' : Systemusers_role_id,
											'Systemusers_first_name' : Systemusers_first_name,
											'Systemusers_last_name' : Systemusers_last_name,
											'Systemusers_email' : Systemusers_email,
											'Systemusers_password' : Systemusers_password,
											'Systemusers_status' : Systemusers_status
											},
											beforeSend: function(){
											}
											}).done(function(html){
												if(parseInt(html)==0){
													$("#info_div").html("An error Occured while saving the record").show();
												}else if(parseInt(html)==1){
													$("#email_error").html("The Email Address has been used before").show();
												}else if(parseInt(html)==2){
													$("#info_div").html("Enter all the fields").show();
												}else if(parseInt(html)==3){
													window.location="index.php?r=systemusers/admin";
												}
											});	
				}
			}else{
				$("#email_error").html("Enter a valid Email Address").show();
			}
		}else{
			$("#last_name_error").html("Last Name Cannot be Blank").show();
		}
	}else{
		$("#first_name_error").html("First Name Cannot be Blank").show();
	}
		
	}else{
	$("#role_error").html("Role Cannot be Blank").show();
}

}
</script>
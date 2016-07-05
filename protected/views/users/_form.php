<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
));
$is_tm=Roles::model()->findByAttributes(array('is_tm'=>1,'status'=>1)); 
$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1)); 
$is_driver=Roles::model()->findByAttributes(array('is_driver'=>1,'status'=>1));
 
$is_tm_id=$is_tm->id;
$default_car_id=$default_car->id;
$is_driver_id=$is_driver->id;
?>
<table>
<tr>
<td width="100">
<b>User Role</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'role_id',CHtml::listData(Roles::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select  User Role--','onchange'=>'contestantFields("Role",this)')); ?>
<div id="role_error"></div>
</td>
</tr>



<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/users/'.$model->photo,"advert",array("width"=>100,"height"=>100)); ?> 
    <?php
}
?>
<input name="photo_hidden" id="photo_hidden" type="hidden" value="<?php echo $model->photo;?>" /> 
</td>
</tr>

<tr>
<td>
<b>User Photo</b>
</td>
<td>
<?php echo CHtml::activeFileField($model, 'photo'); ?>
<div id="photo_error"></div>
</td>
</tr>


<tr>
<td>
<b>First Name</b>
</td>
<td>
<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
<div id="first_name_error"></div>
</td>
</tr>


<tr>
<td>
<b>Last Name</b>
</td>
<td>
<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
<div id="last_name_error"></div>
</td>
</tr>


<tr>
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
<div id="email_error"></div>
</td>
</tr>

<tr>
<td>
<b>Phone number</b>
</td>
<td>
<?php echo $form->textField($model,'phone_number',array('size'=>50,'maxlength'=>50)); ?>
<div id="phone_number_error"></div>
</td>
</tr>


<tr>
<td>
<b>Qualified</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'qualified_status',array(''=>'--Select if Qualified--','1'=>'Yes','0'=>'No'),array('onchange'=>'contestantFields("Qualified",this)')); ?>
<div id="qualified_error"></div>
</td>
</tr>


<tr class="qualified_dl_yes">
<td>
<b>DL number</b>
</td>
<td>
<?php echo $form->textField($model,'dl_number',array('size'=>50,'maxlength'=>50)); ?>
<div id="dl_number_error"></div>
</td>
</tr>

<tr class="qualified_dl_yes">
<td>
<b>DL Expiry Date</b>
</td>
<td>
<?php
	$this->widget('ext.my97DatePicker.JMy97DatePicker',array(
	'name'=>CHtml::activeName($model,'dl_expiry'),
	'value'=>$model->dl_expiry,
	'options'=>array('dateFmt'=>'yyyy-MM-dd'),
 ));
?>
<div id="dl_expiry_error"></div>
</td>
</tr>





<tr class="qualified_dl_yes">
<td>
</td>
<td>
<?php
if($model->dl_photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/dl_photo/'.$model->dl_photo,"advert",array("width"=>100,"height"=>100)); ?> 
    <?php
}
?>
<input name="dl_photo_hidden" id="dl_photo_hidden" type="hidden" value="<?php echo $model->dl_photo;?>" /> 
</td>
</tr>

<tr class="qualified_dl_yes">
<td>
<b>Upload DL</b>
</td>
<td>
<?php echo CHtml::activeFileField($model, 'dl_photo'); ?>
<div id="dl_photo_error"></div>
</td>
</tr>


<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
<div id="status_error"></div>
</td>
</tr>


<tr>
<td></td>
<td>
<input type="hidden" id="current_task" name="current_task" value="<?php if($model->isNewRecord){ echo 'Add';}else{ echo 'Update'; } ?>">
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>
<?php //echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update'); ?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostUsers()')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script language="javascript" type="text/javascript">
$("#Users_phone_number").numeric();
var qualified_status=parseInt(<?php echo $model->qualified_status; ?>);
if(qualified_status==1){
	$(".qualified_dl_yes").show();
}else{
	$(".qualified_dl_yes").hide();
}
highlightMenu('Users');

function contestantFields(field,obj)
{
	var task="<?php if($model->isNewRecord){ echo 'Add';}else{ echo 'Update'; } ?>";
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	var is_driver_id=parseInt(<?php echo $is_driver_id;?>);
	var is_tm_id=parseInt(<?php echo $is_tm_id;?>);

	if(field=='Role'){
		if(value==is_driver_id){
			$("#Users_qualified_status").val(1);
			if(task=='Add'){
				$('#Users_qualified_status').prop("disabled", true);
			}
			$(".qualified_dl_yes").slideDown();
		}else{
			if(task=='Add'){
			$("#Users_qualified_status").val('');
			$('#Users_qualified_status').prop("disabled", false);
			$("#Users_dl_number").val('');
			$("#Users_dl_expiry").val('');
			$("#Users_dl_photo").val('');
			$(".qualified_dl_yes").slideUp();
			}
		}
	}else if(field=='Qualified'){
		if(value==1){
			$(".qualified_dl_yes").slideDown();
		}
		else{
			$("#Users_dl_number").val('');
			$("#Users_dl_expiry").val('');
			$("#Users_dl_photo").val('');
			$(".qualified_dl_yes").slideUp();
		}
	}
}


function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function PostUsers()
{
	var current_task=$("#current_task").val();
	var Users_role_id=$("#Users_role_id").val();
	var photo_hidden=$("#photo_hidden").val();
	var Users_photo=$("#Users_photo").val();
	var Users_first_name=$("#Users_first_name").val();
	var Users_last_name=$("#Users_last_name").val();
	var Users_email=$("#Users_email").val();
	var Users_phone_number=$("#Users_phone_number").val();
	var Users_qualified_status=$("#Users_qualified_status").val();
	var Users_dl_number=$("#Users_dl_number").val();
	var Users_dl_expiry=$("#Users_dl_expiry").val();
	var dl_photo_hidden=$("#dl_photo_hidden").val();
	var Users_dl_photo=$("#Users_dl_photo").val();
	var Users_status=$("#Users_status").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	
	if(photo_hidden=="" && Users_photo=="")
	{
		var Users_photo_ext="";
	}else if(photo_hidden!="" && Users_photo=="")
	{
		var Users_photo_ext="jpg";
	}else if(photo_hidden=="" && Users_photo!="")
	{
		var Users_photo_ext = Users_photo.split('.').pop().toLowerCase(); 
	}else{
		var Users_photo_ext = Users_photo.split('.').pop().toLowerCase();
	}
	
	
	
	
	if(dl_photo_hidden=="" && Users_dl_photo=="")
	{
		var Users_dl_photo_ext="";
	}else if(dl_photo_hidden!="" && Users_dl_photo=="")
	{
		var Users_dl_photo_ext="jpg";
	}else if(dl_photo_hidden=="" && Users_dl_photo!="")
	{
		var Users_dl_photo_ext = Users_dl_photo.split('.').pop().toLowerCase(); 
	}else{
		var Users_dl_photo_ext = Users_dl_photo.split('.').pop().toLowerCase();
	}
	 
	
	if(Users_role_id!==""){
		$("#role_error").removeClass('error').html('').hide();
		
		
		
		if(Users_photo_ext=="png" || Users_photo_ext=="jpg" || Users_photo_ext=="jpeg"){
				$("#photo_error").removeClass('error').html('').hide();
				if(Users_first_name!==""){
				   $("#first_name_error").removeClass('error').html('').hide();
					if(Users_last_name!==""){
					   $("#last_name_error").removeClass('error').html('').hide();
					   if(emailReg.test(Users_email) && Users_email!=""){
							$("#email_error").removeClass('error').html('').hide();
							if(Users_phone_number!==""){
					   		   $("#phone_number_error").removeClass('error').html('').hide();
								if(Users_qualified_status!==""){
								   $("#qualified_error").removeClass('error').html('').hide();
								   if($(".qualified_dl_yes").is(':visible')){  
										if(Users_dl_number!==""){
											$("#dl_number_error").removeClass('error').html('').hide();
										}else{
											 $("#dl_number_error").addClass('error').html("Please enter the DL number.").show();
											 $("#info_frm").removeClass('error').removeClass('success').html('').hide();
										}  
										if(Users_dl_number==""){
										  return false;
										}
										
										
										if(Users_dl_expiry!==""){
											$("#dl_expiry_error").removeClass('error').html('').hide();
										}else{
											 $("#dl_expiry_error").addClass('error').html("Please Select the DL expiry date.").show();
											 $("#info_frm").removeClass('error').removeClass('success').html('').hide();
										}  
										if(Users_dl_expiry==""){
										  return false;
										}
										
										
									
									if(Users_dl_photo_ext=="png" || Users_dl_photo_ext=="jpg" || Users_dl_photo_ext=="jpeg"){
										$("#dl_photo_error").removeClass('error').html('').hide();
									}else{
										 $("#dl_photo_error").addClass('error').html("Please upload the DL as(.JPG or PNG)").show();
										 $("#info_frm").removeClass('error').removeClass('success').html('').hide();
									}
									
									if(Users_dl_photo_ext!="png" && Users_dl_photo_ext!="jpg" && Users_dl_photo_ext!="jpeg"){
										 return false;
									}
									
								   }
								   
									if(Users_status!==""){
									$("#status_error").removeClass('error').html('').hide();
									$('#Users_qualified_status').prop("disabled", false);
									
									/*Start submit the form*/
									$("#save_preloader_div").show();
									$("#users-form").ajaxForm({
									dataType:'html',
									success: function (response){
									$("#save_preloader_div").fadeOut(500);
									try 
									{
									jQuery.parseJSON(response);
									
									var TRANSACTION_DETAILS = jQuery.parseJSON(response);
									$("#"+TRANSACTION_DETAILS.error_div).html(TRANSACTION_DETAILS.error).addClass('error').show();
									$('html, body').animate({
									scrollTop: $("#"+TRANSACTION_DETAILS.field).offset().top	
									});
									} catch(error) {
									if(current_task=='Add'){
									$('#users-form')[0].reset();
									$("#info_frm").addClass('success').removeClass('error').html('User successfully added.').show();
									}else if(current_task=='Update'){
									$("#info_frm").addClass('success').removeClass('error').html('User successfully updated.').show();
									}
									}
									}
									}).submit();
									/*End submit the form*/									
									
									
									}else{
										 $("#status_error").addClass('error').html("Please select status.").show();
								   		 displayError("Please select status.","status_error");
									}
								}else{
								    displayError("Please select if qualified.","qualified_error");
								}
							}else{
						   	  displayError("Please enter phone number.","phone_number_error");
							}
					   }else{
							displayError("Please enter a valid email address.","email_error");
					   }
					}else{
						displayError("Please enter your last name.","last_name_error");
					}
				}else{
					displayError("Please enter your first name.","first_name_error");
				}
			}else{
				displayError("Please upload the user's photo as(.JPG or PNG)","photo_error");
			}
	}else{
		displayError("Please select the user role.","role_error");
	}	
}



$(document).keypress(function(e) {
		if(e.which == 13) {
			PostUsers();
		}
	});
</script>
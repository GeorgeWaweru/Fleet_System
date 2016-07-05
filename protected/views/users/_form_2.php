<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
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
<td>
<b>User Role</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'role_id',CHtml::listData(Roles::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select  User Role--','onchange'=>'contestantFields("Role",this)')); ?>
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
<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update'); ?>
<div id="preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="info_frm"></div>
</td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script language="javascript" type="text/javascript">
<?php
if($model->qualified_status==1){
	?>
	$(".qualified_dl_yes").show();
	<?php
}else{
	?>
	$(".qualified_dl_yes").hide();
	<?php
}
?>


function contestantFields(field,obj)
{
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	var is_driver_id=parseInt(<?php echo $is_driver_id;?>);
	var is_tm_id=parseInt(<?php echo $is_tm_id;?>);

	if(field=='Role'){
		
		if(value==is_driver_id){
			$(".car_field").slideDown();
		}else{
			$(".car_field").slideUp();
		}
		
	}else if(field=='Qualified'){
		if(value==1){
			$(".qualified_dl_yes").slideDown();
		}
		else{
			$("#Users_dl_number").val('');
			$("#Users_dl_photo").val('');
			$(".qualified_dl_yes").slideUp();
		}
	}
}





highlightMenu('Users');
$("form#users-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('Users/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('Users/update');?>';
	var current_task=$("#current_task").val();
	
	var Users_role_id=$("#Users_role_id").val();
	var Users_car_id=$("#Users_car_id").val();
	var photo_hidden=$("#photo_hidden").val();
	var Users_photo=$("#Users_photo").val();
	var Users_first_name=$("#Users_first_name").val();
	var Users_last_name=$("#Users_last_name").val();
	var Users_email=$("#Users_email").val();
	var Users_phone_number=$("#Users_phone_number").val();
	var Users_qualified_status=$("#Users_qualified_status").val();
	var Users_dl_number=$("#Users_dl_number").val();
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
		var Users_photo_ext="jpg";
	}else if(dl_photo_hidden=="" && Users_dl_photo!="")
	{
		var Users_dl_photo_ext = Users_dl_photo.split('.').pop().toLowerCase(); 
	}else{
		var Users_dl_photo_ext = Users_dl_photo.split('.').pop().toLowerCase();
	}
	
	 
	
	if(Users_role_id!==""){
		$("#role_error").removeClass('error').html('').hide();
		if($(".car_field").is(':visible')){
			if(Users_car_id!==""){
				$("#car_error").removeClass('error').html('').hide();
			}else{
				$("#car_error").addClass('error').html('Please select the car.').show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();
			}
			if(Users_car_id==""){
			   return false;
			}
		}
		
		
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
									
									
									/*Start submit the form*/
									if(current_task=='Add'){
									url=addUrl;
									}else if(current_task=='Update'){
									url=updateUrl;
									}	
									$("#preloader_div").show();				 
									var formData = new FormData($(this)[0]);				
									$.ajax({
									url: url,
									type: 'POST',
									data: formData,
									async: false,
									cache: false,
									contentType: false,
									processData: false,
									success: function (response){
									$("#preloader_div").hide();
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
									});
									/*End submit the form*/
									}else{
										 $("#status_error").addClass('error').html("Please select status.").show();
								   		 $("#info_frm").removeClass('error').removeClass('success').html('').hide();
									}
									
								}else{
								   $("#qualified_error").addClass('error').html("Please select if qualified.").show();
								   $("#info_frm").removeClass('error').removeClass('success').html('').hide();
								}
							}else{
							   $("#phone_number_error").addClass('error').html("Please enter phone number").show();
						   	   $("#info_frm").removeClass('error').removeClass('success').html('').hide();
							}
					   }else{
						   $("#email_error").addClass('error').html("Please enter a valid email address.").show();
						   $("#info_frm").removeClass('error').removeClass('success').html('').hide();
					   }
					}else{
						$("#last_name_error").addClass('error').html("Please enter your last name.").show();
						$("#info_frm").removeClass('error').removeClass('success').html('').hide();
					}
				}else{
					$("#first_name_error").addClass('error').html("Please enter your first name.").show();
					$("#info_frm").removeClass('error').removeClass('success').html('').hide();
				}
			}else{
				$("#photo_error").addClass('error').html("Please upload the user's photo as(.JPG or PNG)").show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();
			}
	}else{
		$("#role_error").addClass('error').html('Please select the user role.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();
	}
	
	
	
return false;
});


$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#users-form").submit();	
		}
	});
</script>
<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'companies-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<table>

<tr>
<td>
<b>Industry</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'industry_id',CHtml::listData(Industries::model()->findAll("status='1' AND is_default='0'"),'id','title') ,array('empty' => '--Select Industry--')); ?>
<div id="industries_error"></div>
</td>
</tr>



<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/companies/'.$model->photo,"advert",array("width"=>100,"height"=>100)); ?> 
    <?php
}
?>
<input name="company_hidden" id="company_hidden" type="hidden" value="<?php echo $model->photo;?>" /> 
</td>
</tr>

<tr>
<td>
<b>Company Logo</b>
</td>
<td>
<?php echo CHtml::activeFileField($model, 'photo'); ?>
<div id="photo_error"></div>
</td>
</tr>



<tr>
<td>
<b>Company Name</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
<div id="title_error"></div>
</td>
</tr>

<tr>
<td>
<b>Contact Person</b>
</td>
<td>
<?php echo $form->textField($model,'contact_person',array('size'=>50,'maxlength'=>50)); ?>
<div id="contact_person_error"></div>
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
<b>Phone Number</b>
</td>
<td>
<?php echo $form->textField($model,'phone_number',array('size'=>50,'maxlength'=>50)); ?>
<div id="phone_number_error"></div>
</td>
</tr>


<tr>
<td>
<b>Location</b>
</td>
<td>
<?php echo $form->textField($model,'location',array('size'=>50,'maxlength'=>50)); ?>
<div id="location_error"></div>
</td>
</tr>


<tr>
<td>
<b>No. Of employees</b>
</td>
<td>
<?php echo $form->textField($model,'no_employees',array('size'=>50,'maxlength'=>50)); ?>
<div id="no_employees_error"></div>
</td>
</tr>


<tr>
<td>
<b>No. Of vehicles</b>
</td>
<td>
<?php echo $form->textField($model,'no_vehicles',array('size'=>50,'maxlength'=>50)); ?>
<div id="no_vehicles_error"></div>
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
<br><br>
<div id="info_frm"></div>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
</td>
</tr>
</table>




<?php $this->endWidget(); ?>

</div><!-- form -->



<script language="javascript" type="text/javascript">
$("#Companies_phone_number").numeric();
$("#Companies_no_employees").numeric();
$("#Companies_no_vehicles").numeric();

highlightMenu('Companies');
$("form#companies-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('Companies/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('Companies/update');?>';
	var current_task=$("#current_task").val();
	if(current_task=='Add'){
		url=addUrl;
	}else if(current_task=='Update'){
		url=updateUrl;
	}
	var Companies_industry_id=$("#Companies_industry_id").val();
	var Companies_photo=$("#Companies_photo").val();
	var company_hidden=$("#company_hidden").val();
	var Companies_title=$("#Companies_title").val();
	var Companies_contact_person=$("#Companies_contact_person").val();
	var Companies_email=$("#Companies_email").val();
	var Companies_phone_number=$("#Companies_phone_number").val();
	var Companies_location=$("#Companies_location").val();
	var Companies_no_employees=$("#Companies_no_employees").val();
	var Companies_no_vehicles=$("#Companies_no_vehicles").val();
	var Companies_status=$("#Companies_status").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	
	if(company_hidden=="" && Companies_photo=="")
	{
		var cover_photo_ext="";
	}else if(company_hidden!="" && Companies_photo=="")
	{
		var cover_photo_ext="jpg";
	}else if(company_hidden=="" && Companies_photo!="")
	{
		var cover_photo_ext = Companies_photo.split('.').pop().toLowerCase(); 
	}else{
		var cover_photo_ext = Companies_photo.split('.').pop().toLowerCase();
	}

	if(Companies_industry_id!==""){
		$("#industries_error").removeClass('error').html('').hide();
		if(cover_photo_ext=="png" || cover_photo_ext=="jpg" || cover_photo_ext=="jpeg"){
			$("#photo_error").removeClass('error').html('').hide();
			if(Companies_title!==""){
			$("#title_error").removeClass('error').html('').hide();
			if(Companies_contact_person!==""){
				$("#contact_person_error").removeClass('error').html('').hide();
				if(emailReg.test(Companies_email) && Companies_email!=""){
					$("#email_error").removeClass('error').html('').hide();
					if(Companies_phone_number!==""){
						$("#phone_number_error").removeClass('error').html('').hide();
						if(Companies_location!==""){
							$("#location_error").removeClass('error').html('').hide();
							if(Companies_no_employees!==""){
								$("#no_employees_error").removeClass('error').html('').hide();
								if(Companies_no_vehicles!==""){
									$("#no_vehicles_error").removeClass('error').html('').hide();
									if(Companies_status!==""){
										$("#status_error").removeClass('error').html('').hide();
										$("#save_preloader_div").show();
										
				/*Start submit the form*/
					
				var formData = new FormData($(this)[0]);				
				$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				beforeSend: function(){
					//$("#save_preloader_div").show();
				},
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function (response){
				try 
				{
					$("#save_preloader_div").fadeOut(800);
					jQuery.parseJSON(response);
					var TRANSACTION_DETAILS = jQuery.parseJSON(response);
					$("#"+TRANSACTION_DETAILS.error_div).html(TRANSACTION_DETAILS.error).addClass('error').show();
					$('html, body').animate({
					scrollTop: $("#"+TRANSACTION_DETAILS.field).offset().top	
					});
				} catch(error) {
				if(current_task=='Add'){
					$('#companies-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Company successfully added.').show();
				}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Company successfully updated.').show();
				}
				}
				}
				});
				/*End submit the form*/




									}else{
										$("#status_error").addClass('error').html('Please select the status.').show();
										$("#info_frm").removeClass('error').removeClass('success').html('').hide();
									}
								}else{
									$("#no_vehicles_error").addClass('error').html('Please enter the number of vehicles.').show();
									$("#info_frm").removeClass('error').removeClass('success').html('').hide();
								}
							}else{
								$("#no_employees_error").addClass('error').html('Please enter the number of employees.').show();
								$("#info_frm").removeClass('error').removeClass('success').html('').hide();
							}
						}else{
							$("#location_error").addClass('error').html('Please enter the location.').show();
							$("#info_frm").removeClass('error').removeClass('success').html('').hide();
						}
					}else{
						$("#phone_number_error").addClass('error').html('Please enter the phone number.').show();
						$("#info_frm").removeClass('error').removeClass('success').html('').hide();
					}
				}else{
					$("#email_error").addClass('error').html('Please enter a valid email address.').show();
					$("#info_frm").removeClass('error').removeClass('success').html('').hide();
				}
			}else{
				$("#contact_person_error").addClass('error').html('Please enter the contact persons name.').show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();
			}
		}else{
			$("#title_error").addClass('error').html('Please enter the company name.').show();
			$("#info_frm").removeClass('error').removeClass('success').html('').hide();
		}
		}else{
			$("#photo_error").addClass('error').html("Please upload the company's Logo as(.JPG or PNG)").show();
			$("#info_frm").removeClass('error').removeClass('success').html('').hide();
		}
		}else{
		$("#industries_error").addClass('error').html('Please select the Industry.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();
	}
		
		
	  return false;
});


$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#companies-form").submit();	
		}
	});	
</script>
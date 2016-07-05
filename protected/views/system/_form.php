<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<table>
<tr>
<td>
<b>System</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
<div id="title_error"></div>
</td>
</tr>


<tr>
<td>
<b>Service Type</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'service_type',array(''=>'--Select Service Type--','Service'=>'Service','Repair'=>'Repair')); ?>
<div id="service_type_error"></div>
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
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostSystem()')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">
highlightMenu('Systems');

function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function PostSystem()
{
	var current_task=$("#current_task").val();
	var System_title=$("#System_title").val();
	var System_service_type=$("#System_service_type").val();
	var System_status=$("#System_status").val();
	if(System_title!==""){
		$("#title_error").removeClass('error').html('').hide();
		if(System_service_type!==""){
			$("#service_type_error").removeClass('error').html('').hide();
				if(System_status!==""){
					$("#status_error").removeClass('error').html('').hide();
				/*Start submit the form*/
				$("#save_preloader_div").show();
				$("#system-form").ajaxForm({
				dataType:'html',
				success: function (response){
				$("#save_preloader_div").fadeOut(500);
				try 
				{
				jQuery.parseJSON(response);
				var TRANSACTION_DETAILS = jQuery.parseJSON(response);
				//$("#"+TRANSACTION_DETAILS.field).css('border','1px solid red');
				$("#"+TRANSACTION_DETAILS.error_div).html(TRANSACTION_DETAILS.error).addClass('error').show();
				$('html, body').animate({
				scrollTop: $("#"+TRANSACTION_DETAILS.field).offset().top	
				});	
				} catch(error) {
				if(current_task=='Add'){
				$('#system-form')[0].reset();
				$("#info_frm").addClass('success').removeClass('error').html('Car System successfully added.').show();
				}else if(current_task=='Update'){
				$("#info_frm").addClass('success').removeClass('error').html('Car System successfully updated.').show();
				}
				}
				}
				}).submit();
				/*End submit the form*/					
						
				}else{
					displayError("Please select the status.","status_error");
				}
		}else{
			displayError("Please select the Service Type.","service_type_error");
		}
	}else{
		displayError("Please enter the car system name.","title_error");
	}

}

	


$(document).keypress(function(e) {
		if(e.which == 13) {
			PostSystem();
		}
});
</script>
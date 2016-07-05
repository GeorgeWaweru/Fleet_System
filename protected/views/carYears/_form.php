<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-years-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<table>
<tr>
<td><b>Car Year</b></td>
<td>
<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
<div id="title_error"></div>
</td>
</tr>

<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive'),array('class'=>'parent_form_elements')); ?>
<div id="status_error"></div>
</td>
</tr>

<tr>
<td></td>
<td>
<input type="hidden" id="current_task" name="current_task" value="<?php if($model->isNewRecord){ echo 'Add';}else{ echo 'Update'; } ?>">
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200,'class'=>'parent_form_elements')); ?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostCarYears()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">
highlightMenu('Car Years');

function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}



function PostCarYears()
{
	var current_task=$("#current_task").val();
	var CarYears_title=$("#CarYears_title").val();
	var CarYears_status=$("#CarYears_status").val();
	if(CarYears_title!==""){
		$("#title_error").removeClass('error').html('').hide();
		if(CarYears_status!==""){
			$("#status_error").removeClass('error').html('').hide();
			/*Start submit the form*/
			$("#save_preloader_div").show();
			$("#car-years-form").ajaxForm({
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
				$('#car-years-form')[0].reset();
				$("#info_frm").addClass('success').removeClass('error').html('Year successfully added.').show();
			}else if(current_task=='Update'){
				$("#info_frm").addClass('success').removeClass('error').html('Year successfully updated.').show();
			}
			}
			}
			}).submit();
			/*End submit the form*/	
		}else{
			displayError("Please select the status.","status_error");
		}
	}else{
		displayError("Please enter the Year.","title_error");
	}
}


$(document).keypress(function(e) {
		if(e.which == 13) {
			PostCarYears();
		}
	});
</script>
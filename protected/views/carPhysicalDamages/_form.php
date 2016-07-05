<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-physical-damages-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); 
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
?>
<table>
<tr>
<td width="90">
<b>Car</b>
</td>
<td>
<?php
if($id>0 && intval($model->isNewRecord)==1)
{
	$Cars=Cars::model()->findAll("status='1' AND id=".$id." AND is_default=0 AND company_id=".$LOGGED_IN_COMPANY."");
}else{
	$Cars=Cars::model()->findAll("status='1' AND is_default=0 AND company_id=".$LOGGED_IN_COMPANY."");
}
$data = array();
foreach ($Cars as $item)
{
$CarMake=CarMake::model()->findByPk($item->make_id);
$CarModels=CarModels::model()->findByPk($item->model_id);
$narrative=$CarMake->title." ".$CarModels->title."  (".$item->number_plate.")";
$data[$item->id]=$narrative;  
}
if($id>0 && intval($model->isNewRecord)==1)
{
//array('disabled' => 'disabled')
echo CHtml::activeDropDownList($model, 'car_id', $data);
}else{
echo CHtml::activeDropDownList($model, 'car_id', $data ,array('empty' => '--Select Car--'));
}
?>
<div id="car_error"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_physical_damage/'.$model->photo,"advert",array("width"=>100,"height"=>100)); ?> 
    <?php
}
?>
<input name="photo_hidden" id="photo_hidden" type="hidden" value="<?php echo $model->photo;?>" /> 
</td>
</tr>


<tr>
<td>
<b>Car Photo</b>
</td>
<td>
<?php echo CHtml::activeFileField($model, 'photo'); ?>
<div id="photo_error"></div>
</td>
</tr>


<tr>
<td>
<b>Description</b>
</td>
<td>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<div id="description_error"></div>
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
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostPhysicalDamages()')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">
highlightMenu('Cars');

function PostPhysicalDamages()
{
	var current_task=$("#current_task").val();
	var CarPhysicalDamages_car_id=$("#CarPhysicalDamages_car_id").val();
	var photo_hidden=$("#photo_hidden").val();
	var CarPhysicalDamages_photo=$("#CarPhysicalDamages_photo").val();
	var CarPhysicalDamages_description=$("#CarPhysicalDamages_description").val();
	var CarPhysicalDamages_status=$("#CarPhysicalDamages_status").val();
	
	if(photo_hidden=="" && CarPhysicalDamages_photo=="")
	{
		var ext="";
	}else if(photo_hidden!="" && CarPhysicalDamages_photo=="")
	{
		var ext="jpg";
	}else if(photo_hidden=="" && CarPhysicalDamages_photo!="")
	{
		var ext = CarPhysicalDamages_photo.split('.').pop().toLowerCase(); 
	}else{
		var ext = CarPhysicalDamages_photo.split('.').pop().toLowerCase();
	}

	if(CarPhysicalDamages_car_id!==""){
		$("#car_error").removeClass('error').html('').hide();
		if(ext=="png" || ext=="jpg" || ext=="jpeg"){
			$("#photo_error").removeClass('error').html('').hide();
			if(CarPhysicalDamages_description!==""){
				$("#description_error").removeClass('error').html('').hide();
				if(CarPhysicalDamages_status!==""){
					$("#status_error").removeClass('error').html('').hide();
					
					/*Start submit the form*/
					$("#save_preloader_div").show();
					$("#car-physical-damages-form").ajaxForm({
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
						$('#car-physical-damages-form')[0].reset();
						$("#info_frm").addClass('success').removeClass('error').html('Car Physical damage successfully added.').show();
						}else if(current_task=='Update'){
						$("#info_frm").addClass('success').removeClass('error').html('Car Physical damage successfully updated.').show();
					}
					}
					}
					}).submit();
					/*End submit the form*/	
			
				}else{
					$("#status_error").addClass('error').html("Please select the status.").show();
					$("#info_frm").removeClass('error').removeClass('success').html('').hide();
				}
			}else{
				$("#description_error").addClass('error').html("Please enter the description.").show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();
			}
		}else{
			$("#photo_error").addClass('error').html("Please upload the photo as(.JPG or PNG)").show();
			$("#info_frm").removeClass('error').removeClass('success').html('').hide();
		}
	}else{
		$("#car_error").addClass('error').html("Please select the car.").show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();
	}
}



$(document).keypress(function(e) {
		if(e.which == 13) {
			PostPhysicalDamages();
		}
});
</script>
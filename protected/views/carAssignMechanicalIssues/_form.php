<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-assign-mechanical-issues-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); 

$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
?>

<table>
<tr>
<td width="110">
<b>Car Assignment</b><br><span class="narrative">(Narrative)</span>
</td>
<td>
<?php
$CarAssignment=new CarAssignment;
if($id>0 && intval($model->isNewRecord)==1)
{
	$assignments=CarAssignment::model()->findAll("status='1' AND id=".$id." AND company_id=".$LOGGED_IN_COMPANY."");
}else{
	$assignments=CarAssignment::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY."");
}
$data = array();
foreach ($assignments as $item)
{
$CarsData=Cars::model()->findByPk($item->car_id);
$UsersData=Users::model()->findByPk($item->user_id);
$created_at=$CarAssignment->fomartDate($item->created_at);
$CarMake=CarMake::model()->findByPk($CarsData->make_id);
$CarModels=CarModels::model()->findByPk($CarsData->model_id);
$narrative=$CarMake->title." ".$CarModels->title."  (".$CarsData->number_plate.") Assigned to ".$UsersData->first_name." ".$UsersData->last_name." on ".$created_at;
$data[$item->id]=$narrative;  
}
if($id>0 && intval($model->isNewRecord)==1)
{
	//,array('disabled' => 'disabled')
echo CHtml::activeDropDownList($model, 'car_assignment_id', $data);
}else{
echo CHtml::activeDropDownList($model, 'car_assignment_id', $data ,array('empty' => '--Select Car Assignment Narrative--'));
}
?>
<div id="car_assignment"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_assign_mechanical_issues/'.$model->photo,"advert",array("width"=>100,"height"=>100)); ?> 
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
<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update'); ?>
<div id="preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="info_frm"></div>
</td>
</tr>
</table>

<?php $this->endWidget(); ?>
</div>


<script language="javascript" type="text/javascript">
highlightMenu('Cars Assignment');
$("form#car-assign-mechanical-issues-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('CarAssignMechanicalIssues/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('CarAssignMechanicalIssues/update');?>';
	var current_task=$("#current_task").val();
	var CarAssignMechanicalIssues_car_assignment_id=$("#CarAssignMechanicalIssues_car_assignment_id").val();
	var photo_hidden=$("#photo_hidden").val();
	var CarAssignMechanicalIssues_photo=$("#CarAssignMechanicalIssues_photo").val();
	var CarAssignMechanicalIssues_description=$("#CarAssignMechanicalIssues_description").val();
	var CarAssignMechanicalIssues_status=$("#CarAssignMechanicalIssues_status").val();
	
	
	if(photo_hidden=="" && CarAssignMechanicalIssues_photo=="")
	{
		var ext="";
	}else if(photo_hidden!="" && CarAssignMechanicalIssues_photo=="")
	{
		var ext="jpg";
	}else if(photo_hidden=="" && CarAssignMechanicalIssues_photo!="")
	{
		var ext = CarAssignMechanicalIssues_photo.split('.').pop().toLowerCase(); 
	}else{
		var ext = CarAssignMechanicalIssues_photo.split('.').pop().toLowerCase();
	}
	
	
	
	if(CarAssignMechanicalIssues_car_assignment_id!==""){
		$("#car_assignment").removeClass('error').html('').hide();
		if(ext=="png" || ext=="jpg" || ext=="jpeg"){
			$("#photo_error").removeClass('error').html('').hide();
			if(CarAssignMechanicalIssues_description!==""){
				$("#description_error").removeClass('error').html('').hide();
				if(CarAssignMechanicalIssues_status!==""){
					$("#status_error").removeClass('error').html('').hide();
					/*Start submit the form*/
					$("#preloader_div").show();
					$('#CarAssignMechanicalIssues_car_assignment_id').prop("disabled", false);
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
					$('#CarAssignMechanicalIssues_car_assignment_id').prop("disabled", true);
					$('#car-assign-mechanical-issues-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Car Mechanical issue successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Car Mechanical issue successfully updated.').show();
					}
					}
					}
					});
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
		$("#car_assignment").addClass('error').html("Please select the car assignment.").show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();
	}



	return false;
});



$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#car-assign-mechanical-issues-form").submit();	
		}
});
</script>
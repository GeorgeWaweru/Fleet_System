<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-sub-details-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
));
$type=isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) :"";
if($type=='service'){
	$menu='Service Request';
	$text='Service';
}if($type=='repair'){
	$menu='Repair Request';
	$text='Repair';
}if($type=='fuel'){
	$menu='Fuel Request';
	$text='Fuel';
}


$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$Requests=new Requests;
?>

<table>
<tr>
<td width="80">
<b>Request</b>
</td>
<td>
<?php
$RequestsModel=new Requests;

$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		
if($id>0 && intval($model->isNewRecord)==1 && isset($_REQUEST['type']))
{
	$Requests = Requests::model()->findAll("status='1' AND id=".$id." AND company_id=".$LOGGED_IN_COMPANY." AND request_type='$type'");
}else if(intval($model->isNewRecord)==1 && isset($_REQUEST['type']) && $id==0){
	$Requests = Requests::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY." AND request_type='$type'");
}else{
	$Requests = Requests::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY." AND request_type='$type'");
}
$data = array();
foreach ($Requests as $item)
{
$CarsData=Cars::model()->findByPk($item->car_id);
$CarMake=CarMake::model()->findByPk($CarsData->make_id);
$CarModels=CarModels::model()->findByPk($CarsData->model_id);		
$UsersData=Users::model()->findByPk($item->user_id);
$created_at=$RequestsModel->fomartDate($item->created_at);
$SystemData=System::model()->findByPk($item->system_id);
$SubSystemData=SubSystem::model()->findByPk($item->subsystem_id);
$narrative=$SystemData->title." - ".$SubSystemData->title." (".$CarMake->title." ".$CarModels->title." ".$CarsData->number_plate.")"." Requested by ".$UsersData->first_name." ".$UsersData->last_name." on ".$created_at;
$data[$item->id]=$narrative;  
}
if($id>0 && intval($model->isNewRecord)==1)
{
echo CHtml::activeDropDownList($model, 'request_id', $data);
}else{
echo CHtml::activeDropDownList($model, 'request_id', $data ,array('empty' => '--Select Service Request Narrative--'));
}
?>



<?php
if($id>0 && intval($model->isNewRecord)==1)
{
	
/*echo CHtml::activeDropDownList($model,'request_id',CHtml::listData(Requests::model()->findAll("status='1' AND id=".$id." "),'id','id') ,array('disabled' => 'disabled'));*/ 
}else{
	
//echo CHtml::activeDropDownList($model,'request_id',CHtml::listData(Requests::model()->findAll("status='1'"),'id','id') ,array('empty' => '--Select Request--')); 	
}
?>
<div id="request_error"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/requests/'.$model->photo,"advert",array("width"=>100,"height"=>100)); ?> 
    <?php
}
?>
<input name="photo_hidden" id="photo_hidden" type="hidden" value="<?php echo $model->photo;?>" /> 
</td>
</tr>


<tr>
<td>
<b>Photo</b>
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
</div><!-- form -->
<script language="javascript" type="text/javascript">
highlightMenu('<?php echo $menu;?>');
$("form#request-sub-details-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('RequestSubDetails/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('RequestSubDetails/update');?>';
	var current_task=$("#current_task").val();
	if(current_task=='Add'){
		url=addUrl;
	}else if(current_task=='Update'){
		url=updateUrl;
	}
	var RequestSubDetails_request_id=parseInt($("#RequestSubDetails_request_id").val());
	var RequestSubDetails_photo=$("#RequestSubDetails_photo").val();
	var photo_hidden=$("#photo_hidden").val();
	var RequestSubDetails_description=$("#RequestSubDetails_description").val();
	var RequestSubDetails_status=parseInt($("#RequestSubDetails_status").val());
	
	if(photo_hidden=="" && RequestSubDetails_photo=="")
	{
		var ext="";
	}else if(photo_hidden!="" && RequestSubDetails_photo=="")
	{
		var ext="jpg";
	}else if(photo_hidden=="" && RequestSubDetails_photo!="")
	{
		var ext = RequestSubDetails_photo.split('.').pop().toLowerCase(); 
	}else{
		var ext = RequestSubDetails_photo.split('.').pop().toLowerCase();
	}
	
if(RequestSubDetails_request_id>0){
$("#request_error").removeClass('error').html('').hide();	
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#photo_error").removeClass('error').html('').hide();
	if(RequestSubDetails_description!==""){
		$("#description_error").removeClass('error').html('').hide();
		if(RequestSubDetails_status>0){
			$("#status_error").removeClass('error').html('').hide();
			
			/*Start submit the form*/
					$("#preloader_div").show();
					$('#RequestSubDetails_request_id').prop("disabled", false);
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
						$('#RequestSubDetails_request_id').prop("disabled", true);
					$('#request-sub-details-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('<?php echo $text;?> Request Details successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('<?php echo $text;?> Request Details successfully updated.').show();
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
		$("#description_error").addClass('error').html("Please describe the photo above.").show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
	}
}else{
	$("#photo_error").addClass('error').html("Please upload the photo as(.JPG or PNG)").show();
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}}else{
	$("#request_error").addClass('error').html("Please select the service request.").show();
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}
	  return false;
});


$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#request-sub-details-form").submit();	
		}
	});
	
	
</script>
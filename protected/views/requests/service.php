<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'requests-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
));

$clip_img=CHtml::image('images/clip.png');
$close_img=CHtml::image('images/close.png');
$RequestSubDetails=new RequestSubDetails;
?>

<?php
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$Companies=Companies::model()->findByPk($LOGGED_IN_COMPANY);
$CarAssignment=CarAssignment::model()->findByAttributes(array('user_id'=>$LOGGED_IN_USER_ID,'status'=>1)); 
if(count($CarAssignment)>0)
{
$UsersData=Users::model()->findByPk($LOGGED_IN_USER_ID);
	?>
<table>    
<tr>
<td>
<b>System</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'system_id',CHtml::listData(System::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select System--','onchange'=>'getSubSystem(this)','class'=>'parent_fields')); ?>
<div id="system_error"></div>
</td>
</tr>

<tr>
<td>
<b>Sub System</b>
</td>
<td>
<?php
if($model->isNewRecord){
?>
<select class="dropDownElements" name="Requests[subsystem_id]" id="Requests_subsystem_id">
<option value="0" value="<?php echo !empty($model->model_id) ? $model->model_id:"";?>">--Select Car Model--</option>
</select>
    <?php
}else{
	?>
<?php echo CHtml::activeDropDownList($model,'subsystem_id',CHtml::listData(CarModels::model()->findAll("make_id=".$model->make_id." AND status=1 AND is_default=0"),'id','title') ,array('empty' => '--Select Sub System--','class'=>'dropDownElements parent_fields')); ?> 
    <?php
}
?>
<div id="sub_system_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="sub_system_error"></div>
</td>
</tr>



<tr>
<td>
<b>Description</b>
</td>
<td>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'parent_fields')); ?>
<br>
<b>No Description</b>
<?php echo $form->checkBox($model,'no_description', array('value'=>1, 'uncheckValue'=>0)); ?>
<br>
<div id="description_error"></div>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment" onClick="ShowFields()"><?php echo $clip_img;?></a>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment_hide" onClick="HideFields()"><?php echo $close_img;?></a>
</td>
</tr>

<tr>
<td></td>
<div id="description_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<td id="description_content_section"></td>
</tr>



<tr class="description_fields_section">
<td class="inner_fields">Photo</td>
<td>
<?php echo $form->hiddenField($RequestSubDetails,'request_id',array('size'=>50,'maxlength'=>50)); ?>
<?php echo CHtml::activeFileField($RequestSubDetails, 'photo'); ?>
<input name="sub_details_hidden_photo" id="sub_details_hidden_photo" type="hidden" value="<?php echo $RequestSubDetails->photo;?>" /> 
<div id="sub_details_photo_error"></div>
</td>
</tr>

<tr class="description_fields_section">
<td class="inner_fields description_fields">Description</td>
<td>
<?php echo $form->textArea($RequestSubDetails,'description',array('rows'=>6, 'cols'=>50)); ?>
<div id="sub_details_description_error"></div>
</td>
</tr>

<tr class="description_fields_section">
<td>
</td>
<td>
<input type="button" name="save_sub_details" id="save_sub_details" value="Save Request Details" onClick="SaveSubDetails()">
<div id="sub_details_description_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="sub_details_info_div"></div>
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
<?php echo $form->hiddenField($model,'request_type',array('size'=>60,'maxlength'=>200,'value'=>'service')); ?>
<?php echo $form->hiddenField($model,'car_id',array('size'=>60,'maxlength'=>200,'value'=>intval($UsersData->car_id))); ?>
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update'); ?>
<div id="preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="info_frm"></div>
</td>
</tr>
</table>
	<?php $this->endWidget(); ?>
    <?php
}else{
	?>
    <div class="error">You do not have a car assigned to you at the moment thus you cannot raise a service request</div>
    <?php
}
?>
</div>
<script language="javascript" type="text/javascript">

function SaveSubDetails()
{
		var url='<?php echo Yii::app()->controller->createUrl('Cars/savePhysicalProblems');?>';
		var CarPhysicalDamages_photo=$("#CarPhysicalDamages_photo").val();
		var physical_damages_hidden=$("#physical_damages_hidden").val();
		var CarPhysicalDamages_description=$("#CarPhysicalDamages_description").val();
		var CarPhysicalDamages_car_id=parseInt($("#CarPhysicalDamages_car_id").val());		
		if(physical_damages_hidden=="" && CarPhysicalDamages_photo=="")
		{
			var ext="";
		}else if(physical_damages_hidden!="" && CarPhysicalDamages_photo=="")
		{
			var ext="jpg";
		}else if(physical_damages_hidden=="" && CarPhysicalDamages_photo!="")
		{
			var ext = CarPhysicalDamages_photo.split('.').pop().toLowerCase(); 
		}else{
			var ext = CarPhysicalDamages_photo.split('.').pop().toLowerCase();
		}
		
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#physical_damages_photo_error").removeClass('error').html('').hide();
	if(CarPhysicalDamages_description!==""){
		$("#physical_damages_description_error").removeClass('error').html('').hide();
		if(CarPhysicalDamages_car_id>0){
			postSubdetailsForm(url,type,CarPhysicalDamages_car_id);
		}
	}else{
		$("#physical_damages_description_error").addClass('error').html('Please describe the photo above.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
	}
}else{
	$("#physical_damages_photo_error").addClass('error').html("Please upload the physical damages photo as(.JPG or PNG)").show();
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}
}



function ShowFields()
{
	$(".description_fields_section").show();
	$("#damages_attachment_hide").show();
	$("#damages_attachment").hide();
}

function HideFields()
{
	$(".description_fields_section").hide();
	$("#damages_attachment").show();
	$("#damages_attachment_hide").hide();
	$("#RequestSubDetails_photo").val('');
	$("#RequestSubDetails_description").val('');
	$("#sub_details_photo_error").removeClass('error').html('').hide();
	$("#sub_details_description_error").removeClass('error').html('').hide();
}



$('#Requests_no_description').change(function(){
    var checked = this.checked ? 'yes' : 'no';
	if(checked=='yes'){
		$(".description_fields_section").hide();
		$("#damages_attachment").hide();
		$("#damages_attachment_hide").hide();
		$("#RequestSubDetails_photo").val('');
		$("#RequestSubDetails_description").val('');
		$("#Requests_description").val('');
		
		$("#sub_details_photo_error").removeClass('error').html('').hide();
		$("#sub_details_description_error").removeClass('error').html('').hide();
		$("#description_error").removeClass('error').html('').hide();
	}
});


<?php
if($model->isNewRecord){
?>
$('#Requests_subsystem_id').prop("disabled", true);
<?php
}
?>
highlightMenu('Service Request');

function defaultModels()
{
	$('option', '#Requests_subsystem_id').remove();
	default_values = { "0": "--Select Sub System--"};
	$.each(default_values, function(key, value) {   
			$('#Requests_subsystem_id')
			.append($('<option>', { value : key })
			.text(value)); 
			});
}


function getSubSystem(obj)
{
	defaultModels();
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getSubSystem');?>",
	type: "POST",
	dataType: "html",
	data: {'system_id' : value},
	beforeSend: function(){
		$("#sub_system_preloader_div").show();
	}
	}).done(function(html){
		var selectValues=jQuery.parseJSON(html);
		if (jQuery.isEmptyObject(selectValues))
		{
			$("#sub_system_preloader_div").fadeOut(200,function(){
			$('#Requests_subsystem_id').prop("disabled", true);
			});	
		}else{
			$.each(selectValues, function(key, value) {   
			$('#Requests_subsystem_id')
			.append($('<option>', { value : key })
			.text(value)); 
				$("#sub_system_preloader_div").fadeOut(200,function(){
					$('#Requests_subsystem_id').prop("disabled", false);
				});	
			});	
		}	
	});	
}



$("form#requests-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('Requests/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('Requests/update');?>';
	var current_task=$("#current_task").val();
	if(current_task=='Add'){
		url=addUrl;
	}else if(current_task=='Update'){
		url=updateUrl;
	}
	var Requests_system_id=parseInt($("#Requests_system_id").val());
	var Requests_subsystem_id=parseInt($("#Requests_subsystem_id").val());
	var Requests_description=$("#Requests_description").val();
	var Requests_no_description=$('#Requests_no_description').is(':checked');
	var Requests_status=parseInt($("#Requests_status").val());
	
	if(Requests_system_id>0){
		$("#system_error").removeClass('error').html('').hide();
		if(Requests_subsystem_id>0){
			$("#sub_system_error").removeClass('error').html('').hide();
			if((Requests_description!=="") ||  (Requests_description=="" && Requests_no_description==true)){
				$("#description_error").removeClass('error').html('').hide();
				if(Requests_status>0){
					$("#status_error").removeClass('error').html('').hide();
					
						
/*Start submit the form*/
$("#preloader_div").show();	
$(".dropDownElements").prop("disabled", false);
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
} catch(error){
	if(current_task=='Add'){
	// split the response and enable / disable the relevant fields.
	var parts = response.split(" ",2);
	if(parseInt(parts[0])==0){
		$("#RequestSubDetails_request_id").val(parts[1]);
		$("#damages_attachment").show();
		
	}else{
		$("#RequestSubDetails_request_id").val('');
		$("#damages_attachment").hide();
		
	}
	//End reset parent form values
	$('.parent_fields').val('');
	$("#Requests_subsystem_id").val('');
	//End reset parent form values
	$("#info_frm").addClass('success').removeClass('error').html('Service Request successfully added.').show();
	}else if(current_task=='Update'){
	$("#info_frm").addClass('success').removeClass('error').html('Service Request successfully updated.').show();
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
				$("#description_error").addClass('error').html('Please enter the request description.').show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
			}
		}else{
			$("#sub_system_error").addClass('error').html('Please select the sub system.').show();
			$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
		}
	}else{
		$("#system_error").addClass('error').html('Please select the system.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
	}
	  return false;
});
	


$(document).ready(function(){
		var no_description=parseInt(<?php echo $model->no_description;?>);
		var request_id=parseInt(<?php echo $model->id;?>);
		var action='<?php echo $model->isNewRecord ? 'Add' : 'Update';?>';
		if(action=='Update'){
			if(no_description==0){
				$("#damages_attachment").show();
				//getMechanicalIssues(request_id);
			}

		}
});




$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#requests-form").submit();	
		}
	});
</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<div class="form">
<?php 
if(intval($model->isNewRecord)==1)
{
	$action=Yii::app()->controller->createUrl('Requests/create');
}else{
	$action=Yii::app()->controller->createUrl('Requests/update');
}
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'requests-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
	'action'=>$action
));
if(intval($model->isNewRecord)==1)
{
	?>
    <h3>Add Service Request</h3>
    <?php
}else{
	?>
    <h3>Update Service Request </h3>
    <?php
}

$clip_img=CHtml::image('images/clip.png');
$close_img=CHtml::image('images/close.png');
$RequestSubDetails=new RequestSubDetails;


$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$Companies=Companies::model()->findByPk($LOGGED_IN_COMPANY);

$CarAssignment=CarAssignment::model()->findByAttributes(array('user_id'=>$LOGGED_IN_USER_ID,'status'=>1)); 
if((count($CarAssignment)>0 && $COMPANY_SUB_USER_ROLE=='Driver') ||  $COMPANY_SUB_USER_ROLE=='TM')
{
$UsersData=Users::model()->findByPk($LOGGED_IN_USER_ID);
$CarsData=Cars::model()->findByPk($UsersData->car_id);
?>
<?php
if($COMPANY_SUB_USER_ROLE=='Driver')
{
	?>
    <b>Service request for car- <?php echo $CarsData->number_plate;?></b><br>
    <?php
}
?>
<table>  
<?php
if($COMPANY_SUB_USER_ROLE=='TM')
{
//echo $form->textField($model,'company_id',array('size'=>60,'maxlength'=>200,'value'=>intval($LOGGED_IN_COMPANY)));
?>
<tr>
<td width="130">
<b>Request on behalf of</b>
</td>
<td>
<?php
$Carsdata = array();
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$assignments=CarAssignment::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY."");
foreach ($assignments as $item){
	$Cars=Cars::model()->findByPk($item->car_id);
	$CarMake=CarMake::model()->findByPk($Cars->make_id);
	$CarModels=CarModels::model()->findByPk($Cars->model_id);
	$Users=Users::model()->findByPk($item->user_id);
$Carsdata[$Cars->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") Assigned to ".$Users->first_name." ".$Users->last_name; 
}
echo CHtml::activeDropDownList($model, 'car_id', $Carsdata ,array('empty' => '--Request on behalf of--','class'=>'parent_form_elements'));
?>
<div id="car_error"></div>
</td>
</tr>
    <?php
}
?> 
<tr>
<td>
<b>System</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'system_id',CHtml::listData(System::model()->findAll("status='1' AND service_type='Service' AND is_default=0"),'id','title') ,array('empty' => '--Select System--','onchange'=>'getSubSystem(this)','class'=>'parent_fields parent_form_elements')); ?>
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
<select class="dropDownElements" name="Requests[subsystem_id]" id="Requests_subsystem_id" class="parent_form_elements">
<option value="0" value="<?php echo !empty($model->model_id) ? $model->model_id:"";?>">--Select Sub System--</option>
</select>
    <?php
}else{
	?>
<?php echo CHtml::activeDropDownList($model,'subsystem_id',CHtml::listData(SubSystem::model()->findAll("system_id=".$model->system_id." AND status=1 AND is_default=0"),'id','title') ,array('empty' => '--Select Sub System--','class'=>'dropDownElements parent_fields parent_form_elements')); ?> 
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
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'parent_fields parent_form_elements')); ?>
<br>
<b>No Description</b>
<?php echo $form->checkBox($model,'no_description', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<br>
<div id="description_error"></div>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment" onClick="ShowFields()"><?php echo $clip_img;?></a>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment_hide" onClick="HideFields()"><?php echo $close_img;?></a>
</td>
</tr>

<tr>
<td></td>
<div id="sub_details_content_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<td id="sub_details_content_section"></td>
</tr>



<tr class="description_fields_section">
<td class="inner_fields">Photo</td>
<td>
<?php echo $form->hiddenField($RequestSubDetails,'request_id',array('size'=>50,'maxlength'=>50,'value'=>$model->id)); ?>
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
<div id="sub_details_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="sub_details_info_div"></div>
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
<?php echo $form->hiddenField($model,'request_type',array('size'=>60,'maxlength'=>200,'value'=>'service')); ?>
<?php
if($COMPANY_SUB_USER_ROLE=='Driver')
{
	echo $form->hiddenField($model,'car_id',array('size'=>60,'maxlength'=>200,'value'=>intval($UsersData->car_id)));
	//echo $form->textField($model,'company_id',array('size'=>60,'maxlength'=>200,'value'=>intval($UsersData->company_id)));
}
?>

<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostService()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>
    <?php
}else{
	?>
    <div class="error">You do not have a car assigned to you at the moment thus you cannot raise a service request</div>
    <?php
}
?>
<?php $this->endWidget(); ?>
</div>
<script language="javascript" type="text/javascript">

function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function SaveSubDetails()
{
		var url='<?php echo Yii::app()->controller->createUrl('Requests/saveSubDetails');?>';
		var RequestSubDetails_photo =$("#RequestSubDetails_photo ").val();
		var sub_details_hidden_photo=$("#sub_details_hidden_photo").val();
		var RequestSubDetails_description=$("#RequestSubDetails_description").val();
		var RequestSubDetails_request_id=parseInt($("#RequestSubDetails_request_id").val());
		if(sub_details_hidden_photo=="" && RequestSubDetails_photo=="")
		{
			var ext="";
		}else if(sub_details_hidden_photo!="" && RequestSubDetails_photo=="")
		{
			var ext="jpg";
		}else if(sub_details_hidden_photo=="" && RequestSubDetails_photo!="")
		{
			var ext = RequestSubDetails_photo.split('.').pop().toLowerCase(); 
		}else{
			var ext = RequestSubDetails_photo.split('.').pop().toLowerCase();
		}
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#sub_details_photo_error").removeClass('error').html('').hide();
	if(RequestSubDetails_description!==""){
		$("#sub_details_description_error").removeClass('error').html('').hide();
		if(RequestSubDetails_request_id>0){
			postSubdetailsForm(url,RequestSubDetails_request_id);
		}
	}else{
		$("#sub_details_description_error").addClass('error').html('Please describe the photo above.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
	}
}else{
	$("#sub_details_photo_error").addClass('error').html("Please upload the photo as(.JPG or PNG)").show();
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}
}

function getRequestSubDetails(id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getRequestSubDetails');?>",
	type: "POST",
	dataType: "html",
	data: {'id' : id},
	beforeSend: function(){
		$("#sub_details_content_preloading_div").show();
	}
	}).done(function(html){
		$("#sub_details_content_preloading_div").hide();
		$("#sub_details_content_section").html(html).show();
	});		
}



function postSubdetailsForm(url,RequestSubDetails_request_id)
{	
$("#sub_details_preloading_div").show();
/*Start submit the form*/
var formData = new FormData($("#requests-form")[0]);				
$.ajax({
url: url,
type: 'POST',
data: formData,
async: false,
cache: false,
contentType: false,
processData: false,
success: function (response){
$("#sub_details_preloading_div").hide();
	if(parseInt(response)==1){
		$("#RequestSubDetails_photo").val('');
		$("#RequestSubDetails_description").val('');
		$("#sub_details_info_div").addClass('success').removeClass('error').html('Service Request details successfully saved.').show();
		getRequestSubDetails(RequestSubDetails_request_id);
	}else{
		$("#sub_details_info_div").addClass('error').removeClass('success').html('Error Service Request details.').show();
	}	
}
});
/*End submit the form*/
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
		$("#Requests_description").val('').attr('disabled',true);
		$("#sub_details_photo_error").removeClass('error').html('').hide();
		$("#sub_details_description_error").removeClass('error').html('').hide();
		$("#description_error").removeClass('error').html('').hide();
	}else{
		$("#Requests_description").val('').attr('disabled',false);
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

function PostService()
{
	var role='<?php echo $COMPANY_SUB_USER_ROLE;?>';
	var current_task=$("#current_task").val();
	var Requests_car_id=parseInt($("#Requests_car_id").val());
	var Requests_system_id=parseInt($("#Requests_system_id").val());
	var Requests_subsystem_id=parseInt($("#Requests_subsystem_id").val());
	var Requests_description=$("#Requests_description").val();
	var Requests_no_description=$('#Requests_no_description').is(':checked');
	var Requests_status=parseInt($("#Requests_status").val());
	
	
if(Requests_car_id>0 && role=='TM' || role=='Driver'){
		$("#car_error").removeClass('error').html('').hide();
	if(Requests_system_id>0){
		$("#system_error").removeClass('error').html('').hide();
		if(Requests_subsystem_id>0){
			$("#sub_system_error").removeClass('error').html('').hide();
			if((Requests_description!=="") ||  (Requests_description=="" && Requests_no_description==true)){
				$("#description_error").removeClass('error').html('').hide();
				if(Requests_status>0){
					$("#status_error").removeClass('error').html('').hide();

					/*Start submit the form*/
					$(".dropDownElements").prop("disabled", false);
					$("#save_preloader_div").show();
					$("#requests-form").ajaxForm({
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
					//$('.parent_fields').val('');
					//$("#Requests_subsystem_id").val('');
					//End reset parent form values
					//$('.parent_form_elements').prop("disabled", true);
					//$('.parent_form_btn').hide().prop("type", "button");
					$("#Requests_description").val('').attr('disabled',false);
					$('#requests-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Service Request successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Service Request successfully updated.').show();
					}
					}
					}
					}).submit();
					/*End submit the form*/

					
				}else{
					displayError('Please select the status.','status_error');
				}
			}else{
				displayError('Please enter the request description.','description_error');
			}
		}else{
			displayError('Please select the sub system.','sub_system_error');
		}
	}else{
		displayError('Please select the system.','system_error');
	}}else{
		displayError('Please select who you are requesting on behalf.','car_error');
	}
}

	


function DeleteRecord(id,request_id)
{
	var delete_controller='RequestSubDetails';
	var path="index.php?r="+delete_controller+"/delete&id="+id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			getRequestSubDetails(request_id);
		});		
}



$(document).ready(function(){
		var no_description=parseInt(<?php echo $model->no_description;?>);
		if(no_description==1)
		{
			$("#Requests_description").val('').attr('disabled',true);
		}else{
			$("#Requests_description").attr('disabled',false);
		}
		
		var request_id=parseInt(<?php echo $model->id;?>);
		var action='<?php echo $model->isNewRecord ? 'Add' : 'Update';?>';
		if(action=='Update'){
			if(no_description==0){
				$("#damages_attachment").show();
				getRequestSubDetails(request_id);
			}
		}
});



$(document).keypress(function(e) {
		if(e.which == 13) {
			PostService();
		}
	});
</script>
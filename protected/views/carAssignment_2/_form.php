<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-assignment-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
));

$clip_img=CHtml::image('images/clip.png');
$close_img=CHtml::image('images/close.png');
$CarPhysicalDamages=new CarAssignPhysicalDamages;
$CarMechanicalIssues=new CarAssignMechanicalIssues;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
?>
<table>
<tr>
<td>
<b>Car</b>
</td>
<td>
<?php 

if($model->isNewRecord){
	$cars=Cars::model()->findAll("status='1' AND is_default=0 AND company_id=$LOGGED_IN_USER_ID AND is_assigned=0"); 
}else{
	$cars=Cars::model()->findAll("status='1' AND is_default=0 AND company_id=$LOGGED_IN_USER_ID");
}
$Carsdata = array();
foreach ($cars as $item){
$CarMake=CarMake::model()->findByPk($item->make_id);
$CarModels=CarModels::model()->findByPk($item->model_id);
$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$item->number_plate.")"; 
}
echo CHtml::activeDropDownList($model, 'car_id', $Carsdata ,array('empty' => '--Select Car--','class'=>'parent_form_elements'));




/*if($model->isNewRecord){
echo CHtml::activeDropDownList($model,'car_id',CHtml::listData(Cars::model()->findAll("status='1' AND is_default=0 AND company_id=$LOGGED_IN_USER_ID AND is_assigned=0"),'id','number_plate') ,array('empty' => '--Select Car--')); 
}else{
echo CHtml::activeDropDownList($model,'car_id',CHtml::listData(Cars::model()->findAll("status='1' AND is_default=0 AND company_id=$LOGGED_IN_USER_ID"),'id','number_plate') ,array('empty' => '--Select Car--')); 
}*/
?>
<div id="car_error"></div>
</td>
</tr>


<tr>
<td>
<b>User </b>
</td>
<td>
<?php 
$is_driver=Roles::model()->findByAttributes(array('is_driver'=>1,'status'=>1));
$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1));
$driver_role_id=$is_driver->id;
$default_car_id=$default_car->id;
$sql="SELECT * from tbl_users WHERE status='1' AND role_id=".$driver_role_id." AND company_id=$LOGGED_IN_USER_ID "."
	  AND car_id=".$default_car_id."";
$users=Users::model()->findAllBySql($sql);
$data = array();
foreach ($users as $item)
{
$data[$item->id] = $item->first_name . ' '. $item->last_name;   
}
echo CHtml::activeDropDownList($model, 'user_id', $data ,array('empty' => '--Select User--','class'=>'parent_form_elements'));
?>
<div id="user_error"></div>
</td>
</tr>



<tr>
<td>
<b>Spare Tyre</b>
</td>
<td>
<?php echo $form->checkBox($model,'spare_tire', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<div id="spare_tire_error"></div>
</td>
</tr>

<tr>
<td>
<b>Fire Extinguisher</b>
</td>
<td>
<?php echo $form->checkBox($model,'fire_extinguisher', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<div id="fire_extinguisher_error"></div>
</td>
</tr>


<tr>
<td>
<b>Jerk</b>
</td>
<td>
<?php echo $form->checkBox($model,'jerk', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<div id="jerk_error"></div>
</td>
</tr>

<tr>
<td>
<b>Wheel Spanner</b>
</td>
<td>
<?php echo $form->checkBox($model,'wheel_spanner', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<div id="wheel_spanner_error"></div>
</td>
</tr>



<tr>
<td>
<b>Physical Damages</b>
</td>
<td>
<?php echo $form->textArea($model,'physical_damages',array('rows'=>6, 'cols'=>50,'class'=>'parent_form_elements')); ?>
<br>
<b>No Physical Damages</b>
<?php echo $form->checkBox($model,'no_physical_damages', array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<br>
<div id="physical_damages_error"></div>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment" onClick="ShowDamagesFields()"><?php echo $clip_img;?></a>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment_hide" onClick="HideDamagesFields()"><?php echo $close_img;?></a>
</td>
</tr>

<tr>
<td></td>
<div id="physical_damages_content_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<td id="physical_damages_content_section"></td>
</tr>



<tr class="physical_damages_fields_section">
<td class="inner_fields">Photo</td>
<td>
<?php echo $form->hiddenField($CarPhysicalDamages,'car_assignment_id',array('size'=>50,'maxlength'=>50,'value'=>$model->id)); ?>
<?php echo CHtml::activeFileField($CarPhysicalDamages, 'photo'); ?>
<input name="physical_damages_hidden" id="physical_damages_hidden" type="hidden" value="<?php echo $CarPhysicalDamages->photo;?>" /> 
<div id="physical_damages_photo_error"></div>
</td>
</tr>

<tr class="physical_damages_fields_section">
<td class="inner_fields physical_damages_fields">Description</td>
<td>
<?php echo $form->textArea($CarPhysicalDamages,'description',array('rows'=>6, 'cols'=>50)); ?>
<div id="physical_damages_description_error"></div>
</td>
</tr>

<tr class="physical_damages_fields_section">
<td>
</td>
<td>
<input type="button" name="save_physical" id="save_physical" value="Save Physical Damages" onClick="SaveSubDetails('Physical')">
<div id="physical_damages_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="physical_damages_info_div"></div>
</td>
</tr>


<tr>
<td>
<b>Mechanical Issues</b>
</td>
<td>
<?php echo $form->textArea($model,'mechanical_issues',array('rows'=>6, 'cols'=>50,'class'=>'parent_form_elements')); ?>
<div id="mechanical_issues_error"></div>
<br>
<b>No Mechanical Issues</b> 
<?php echo $form->checkBox($model,'no_mechanical_issues',array('value'=>1, 'uncheckValue'=>0,'class'=>'parent_form_elements')); ?>
<br>
<a href="javascript:void(0);" class="attachment_link" id="mechanical_attachment" onClick="ShowMechanicalFields()"><?php echo $clip_img;?></a>
<a href="javascript:void(0);" class="attachment_link" id="mechanical_attachment_hide" onClick="HideMechanicalFields()"><?php echo $close_img;?></a>
</td>
</tr>



<tr>
<td></td>
<div id="Mechanical_content_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<td id="Mechanical_content_section"></td>
</tr>


<tr class="Mechanical_fields_section">
<td class="inner_fields">Photo</td>
<td>
<?php echo $form->hiddenField($CarMechanicalIssues,'car_assignment_id',array('size'=>50,'maxlength'=>50,'value'=>$model->id)); ?>
<?php echo CHtml::activeFileField($CarMechanicalIssues, 'photo'); ?>
<input name="mechanical_issues_hidden" id="mechanical_issues_hidden" type="hidden" value="<?php echo $CarMechanicalIssues->photo;?>" /> 
<div id="Mechanical_photo_error"></div>
</td>
</tr>

<tr class="Mechanical_fields_section">
<td class="inner_fields Mechanical_fields">Description</td>
<td>
<?php echo $form->textArea($CarMechanicalIssues,'description',array('rows'=>6, 'cols'=>50)); ?>
<div id="Mechanical_description_error"></div>
</td>
</tr>

<tr class="Mechanical_fields_section">
<td>
</td>
<td>
<input type="button" name="save_mechanical" id="save_mechanical" value="Save Mechanical Issues" onClick="SaveSubDetails('Mechanical')">
<div id="mechanical_issues_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="mechanical_issues_info_div"></div>
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
<?php echo $form->hiddenField($model,'company_id',array('size'=>60,'maxlength'=>200,'value'=>$LOGGED_IN_COMPANY)); ?>
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array('class'=>'parent_form_btn')); ?>
<div id="preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="info_frm"></div>
</td>
</tr>
</table>



<?php $this->endWidget(); ?>

</div><!-- form -->
<script language="javascript" type="text/javascript">
highlightMenu('Cars Assignment');
function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1000);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function SaveSubDetails(type)
{
	if(type=='Physical'){
		var url='<?php echo Yii::app()->controller->createUrl('CarAssignment/savePhysicalProblems');?>';
		var CarAssignPhysicalDamages_photo=$("#CarAssignPhysicalDamages_photo").val();
		var physical_damages_hidden=$("#physical_damages_hidden").val();
		var CarAssignPhysicalDamages_description=$("#CarAssignPhysicalDamages_description").val();
		var CarAssignPhysicalDamages_car_assignment_id=parseInt($("#CarAssignPhysicalDamages_car_assignment_id").val());		
		if(physical_damages_hidden=="" && CarAssignPhysicalDamages_photo=="")
		{
			var ext="";
		}else if(physical_damages_hidden!="" && CarAssignPhysicalDamages_photo=="")
		{
			var ext="jpg";
		}else if(physical_damages_hidden=="" && CarAssignPhysicalDamages_photo!="")
		{
			var ext = CarAssignPhysicalDamages_photo.split('.').pop().toLowerCase(); 
		}else{
			var ext = CarAssignPhysicalDamages_photo.split('.').pop().toLowerCase();
		}
		
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#physical_damages_photo_error").removeClass('error').html('').hide();
	if(CarAssignPhysicalDamages_description!==""){
		$("#physical_damages_description_error").removeClass('error').html('').hide();
		if(CarAssignPhysicalDamages_car_assignment_id>0){
			postSubdetailsForm(url,type,CarAssignPhysicalDamages_car_assignment_id);
		}
	}else{
		displayError("Please describe the photo above.","physical_damages_description_error");	
	}
}else{
		displayError("Please upload the physical damages photo as(.JPG or PNG)","physical_damages_photo_error");
}
	}else if(type=='Mechanical'){
		var url='<?php echo Yii::app()->controller->createUrl('CarAssignment/saveMechanicalIssues');?>';
		var CarAssignMechanicalIssues_photo=$("#CarAssignMechanicalIssues_photo").val();
		var mechanical_issues_hidden=$("#mechanical_issues_hidden").val();
		var CarAssignMechanicalIssues_description=$("#CarAssignMechanicalIssues_description").val();
		var CarAssignMechanicalIssues_car_assignment_id=parseInt($("#CarAssignMechanicalIssues_car_assignment_id").val());
		
		if(mechanical_issues_hidden=="" && CarAssignMechanicalIssues_photo=="")
		{
			var ext="";
		}else if(mechanical_issues_hidden!="" && CarAssignMechanicalIssues_photo=="")
		{
			var ext="jpg";
		}else if(mechanical_issues_hidden=="" && CarAssignMechanicalIssues_photo!="")
		{
			var ext = CarAssignMechanicalIssues_photo.split('.').pop().toLowerCase(); 
		}else{
			var ext = CarAssignMechanicalIssues_photo.split('.').pop().toLowerCase();
		}
		
		
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#Mechanical_photo_error").removeClass('error').html('').hide();
	if(CarAssignMechanicalIssues_description!==""){
		$("#Mechanical_description_error").removeClass('error').html('').hide();
		if(CarAssignMechanicalIssues_car_assignment_id>0){
			postSubdetailsForm(url,type,CarAssignMechanicalIssues_car_assignment_id);
		}
	}else{
		displayError("Please describe the photo above.","Mechanical_description_error");
	}
}else{
		displayError("Please upload the mechanical issues photo as(.JPG or PNG)","Mechanical_photo_error");
}
	}
}


function getPhysicalDamages(car_assignment_id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getPhysicalDamages');?>",
	type: "POST",
	dataType: "html",
	data: {'car_assignment_id' : car_assignment_id},
	beforeSend: function(){
		$("#physical_damages_content_preloading_div").show();
	}
	}).done(function(html){
		$("#physical_damages_content_preloading_div").hide();
		$("#physical_damages_content_section").html(html).show();
	});	
	
}

function getMechanicalIssues(car_assignment_id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getMechanicalIssues');?>",
	type: "POST",
	dataType: "html",
	data: {'car_assignment_id' : car_assignment_id},
	beforeSend: function(){
		$("#Mechanical_content_preloading_div").show();
	}
	}).done(function(html){
		$("#Mechanical_content_preloading_div").hide();
		$("#Mechanical_content_section").html(html).show();
	});
}


function postSubdetailsForm(url,type,car_assignment_id)
{	
if(type=='Physical'){
	$("#physical_damages_preloading_div").show();
}else if(type=='Mechanical'){
	$("#mechanical_issues_preloading_div").show();
}
/*Start submit the form*/
var formData = new FormData($("#car-assignment-form")[0]);				
$.ajax({
url: url,
type: 'POST',
data: formData,
async: false,
cache: false,
contentType: false,
processData: false,
success: function (response){
if(type=='Physical'){
	$("#physical_damages_preloading_div").hide();
}else if(type=='Mechanical'){
	$("#mechanical_issues_preloading_div").hide();
}

	if(parseInt(response)==1){
		if(type=='Physical'){
		//Reset values
		$("#CarAssignPhysicalDamages_photo").val('');
		$("#CarAssignPhysicalDamages_description").val('');
		//End reset values
		$("#physical_damages_info_div").addClass('success').removeClass('error').html('Physical damages details successfully saved.').show();
		getPhysicalDamages(car_assignment_id);
		
		}else if(type=='Mechanical'){
		//Reset values
		$("#CarAssignMechanicalIssues_photo").val('');
		$("#CarAssignMechanicalIssues_description").val('');
		//End reset values
		$("#mechanical_issues_info_div").addClass('success').removeClass('error').html('Mechanical issues successfully saved.').show();
		getMechanicalIssues(car_assignment_id);
		}
	}else{
		if(type=='Physical'){
		$("#physical_damages_info_div").addClass('error').removeClass('success').html('Error saving Physical damages details.').show();
		}else if(type=='Mechanical'){
		$("#mechanical_issues_info_div").addClass('error').removeClass('success').html('Error saving Mechanical issues.').show();
		}
	}	
}
});
/*End submit the form*/
}




function ShowDamagesFields()
{
	$(".physical_damages_fields_section").show();
	$("#damages_attachment_hide").show();
	$("#damages_attachment").hide();
}

function HideDamagesFields()
{
	$(".physical_damages_fields_section").hide();
	$("#damages_attachment").show();
	$("#damages_attachment_hide").hide();
	$("#CarAssignPhysicalDamages_photo").val('');
	$("#CarAssignPhysicalDamages_description").val('');
	$("#physical_damages_photo_error").removeClass('error').html('').hide();
	$("#physical_damages_description_error").removeClass('error').html('').hide();

}

$('#CarAssignment_no_physical_damages').change(function(){
    var checked = this.checked ? 'yes' : 'no';
	if(checked=='yes'){
		$(".physical_damages_fields_section").hide();
		$("#damages_attachment").hide();
		$("#damages_attachment_hide").hide();
		$("#CarAssignPhysicalDamages_photo").val('');
		$("#CarAssignPhysicalDamages_description").val('');
		$("#CarAssignment_physical_damages").val('').attr('disabled',true);
		$("#physical_damages_photo_error").removeClass('error').html('').hide();
		$("#physical_damages_description_error").removeClass('error').html('').hide();
		$("#physical_damages_error").removeClass('error').html('').hide();
	}else{
		$("#CarAssignment_physical_damages").val('').attr('disabled',false);
	}
});



function ShowMechanicalFields()
{
	$(".Mechanical_fields_section").show();
	$("#mechanical_attachment_hide").show();
	$("#mechanical_attachment").hide();
	
}

function HideMechanicalFields()
{
	$(".Mechanical_fields_section").hide();
	$("#mechanical_attachment").show();
	$("#mechanical_attachment_hide").hide();
	$("#CarAssignMechanicalIssues_photo").val('');
	$("#CarAssignMechanicalIssues_description").val('');
	$("#Mechanical_photo_error").removeClass('error').html('').hide();
	$("#Mechanical_description_error").removeClass('error').html('').hide();
}


$('#CarAssignment_no_mechanical_issues').change(function(){
    var checked = this.checked ? 'yes' : 'no';
	if(checked=='yes'){
		$(".Mechanical_fields_section").hide();
		$("#mechanical_attachment").hide();
		$("#mechanical_attachment_hide").hide();
		$("#CarAssignMechanicalIssues_photo").val('');
		$("#CarAssignMechanicalIssues_description").val('');
		$("#CarAssignment_mechanical_issues").val('').attr('disabled',true);
		$("#Mechanical_photo_error").removeClass('error').html('').hide();
		$("#Mechanical_description_error").removeClass('error').html('').hide();
		$("#mechanical_issues_error").removeClass('error').html('').hide();
	}else{
		$("#CarAssignment_mechanical_issues").val('').attr('disabled',false);
	}
});




$("form#car-assignment-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('CarAssignment/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('CarAssignment/update');?>';
	var current_task=$("#current_task").val();
	if(current_task=='Add'){
		url=addUrl;
	}else if(current_task=='Update'){
		url=updateUrl;
	}
	var CarAssignment_car_id=$("#CarAssignment_car_id").val();
	var CarAssignment_user_id=$("#CarAssignment_user_id").val();
	var CarAssignment_physical_damages=$("#CarAssignment_physical_damages").val();
	var CarAssignment_no_physical_damages=$('#CarAssignment_no_physical_damages').is(':checked');
	var CarAssignment_mechanical_issues=$("#CarAssignment_mechanical_issues").val();
	var CarAssignment_no_mechanical_issues=$('#CarAssignment_no_mechanical_issues').is(':checked');
	var CarAssignment_status=$("#CarAssignment_status").val();
	
	if(CarAssignment_car_id!==""){
		$("#car_error").removeClass('error').html('').hide();
		
			$("#user_error").removeClass('error').html('').hide();
			if(CarAssignment_user_id!==""){
				$("#user_error").removeClass('error').html('').hide();
				if((CarAssignment_physical_damages!=="") ||  (CarAssignment_physical_damages=="" && CarAssignment_no_physical_damages==true)){
					$("#physical_damages_error").removeClass('error').html('').hide();
					if((CarAssignment_mechanical_issues!=="") ||  (CarAssignment_mechanical_issues=="" && CarAssignment_no_mechanical_issues==true)){
						$("#mechanical_issues_error").removeClass('error').html('').hide();
						if(CarAssignment_status!==""){
							$("#status_error").removeClass('error').html('').hide();
							
							
							
$("#preloader_div").show();							
/*Start submit the form*/
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
	// split the response and enable/ disable the relevant fields.
	var parts = response.split(" ",3);
	if(parseInt(parts[0])==0){
		$("#damages_attachment").show();
		$("#CarAssignPhysicalDamages_car_assignment_id").val(parts[2]);
	}else{
		$("#damages_attachment").hide();
		$("#CarAssignPhysicalDamages_car_assignment_id").val('');
	}
	if(parseInt(parts[1])==0){
		$("#mechanical_attachment").show();
		$("#CarAssignMechanicalIssues_car_assignment_id").val(parts[2]);
	}else{
		$("#mechanical_attachment").hide();
		$("#CarAssignMechanicalIssues_car_assignment_id").val('');
	}
	
	
	$('.parent_form_elements').prop("disabled", true);
	$('.parent_form_btn').hide().prop("type", "button");
	$("#info_frm").addClass('success').removeClass('error').html('Car successfully Assigned.').show();
	}else if(current_task=='Update'){
	$("#info_frm").addClass('success').removeClass('error').html('Car Assignment successfully updated.').show();
	}
}
}
});
/*End submit the form*/

						}else{
							displayError("Please select the status.",'status_error');
					}
					}else{
						displayError("Please enter the mechanical issues.",'mechanical_issues_error');
					}
				}else{
					displayError("Please enter the physical damages.",'physical_damages_error');
				}
			}else{
				displayError("Please select the user.",'user_error');
			}  
	}else{
		displayError("Please select the car.",'car_error');
	}  
	
	
	return false;
});


$(document).ready(function(){
		var no_physical_damages=parseInt(<?php echo $model->no_physical_damages;?>);
		var no_mechanical_issues=parseInt(<?php echo $model->no_mechanical_issues;?>);
		
		if(no_physical_damages==1)
		{
			$("#CarAssignment_physical_damages").val('').attr('disabled',true);
		}else{
			$("#CarAssignment_physical_damages").attr('disabled',false);
		}
		
		if(no_mechanical_issues==1)
		{
			$("#CarAssignment_mechanical_issues").val('').attr('disabled',true);
		}else{
			$("#CarAssignment_mechanical_issues").attr('disabled',false);
		}
		
		var car_id=parseInt(<?php echo $model->id;?>);
		var action='<?php echo $model->isNewRecord ? 'Add' : 'Update';?>';
		if(action=='Update'){
			if(no_mechanical_issues==0){
				$("#mechanical_attachment").show();
				getMechanicalIssues(car_id);
			}
			if(no_physical_damages==0){
				$("#damages_attachment").show();
				getPhysicalDamages(car_id);
			}
		}
});


$(document).keypress(function(e) {
		if(e.which == 13) {
			if($(".Mechanical_fields_section").is(':visible')){
				SaveSubDetails('Mechanical');
			}else if($(".physical_damages_fields_section").is(':visible')){
				SaveSubDetails('Physical');
			}else{
				$("#car-assignment-form").submit();	
			}
			
		}
	});
</script>
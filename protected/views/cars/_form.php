<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cars-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); 

$clip_img=CHtml::image('images/clip.png');
$close_img=CHtml::image('images/close.png');
$CarPhysicalDamages=new CarPhysicalDamages;
$CarMechanicalIssues=new CarMechanicalIssues;
?>

<table>
<tr>
<td width="130">
<b>Registration No.</b>
</td>
<td>
<?php echo $form->textField($model,'number_plate',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements')); ?>
<div id="number_plate_error"></div>
</td>
</tr>


<tr>
<td>
<b>Car Make</b>
</td>
<td>
 <?php 
 echo CHtml::activeDropDownList($model,'make_id',CHtml::listData(CarMake::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select Car Make--','onchange'=>'getModels(this)','class'=>'parent_form_elements'));
  ?>
<div id="car_make_error"></div>
</td>
</tr>

<tr>
<td>
<b>Car Model</b>
</td>
<td>
<?php
if($model->isNewRecord){
?>
<select class="dropDownElements parent_form_elements" name="Cars[model_id]" id="Cars_model_id">
<option value="0" value="<?php echo !empty($model->model_id) ? $model->model_id:"";?>">--Select Car Model--</option>
</select>
    <?php
}else{
	?>
<?php echo CHtml::activeDropDownList($model,'model_id',CHtml::listData(CarModels::model()->findAll("make_id=".$model->make_id." AND status=1 AND is_default=0"),'id','title') ,array('empty' => '--Select Car Model--','class'=>'dropDownElements parent_form_elements')); ?> 
    <?php
}
?>
<div id="car_model_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="car_model_error"></div>
</td>
</tr>


<tr>
<td>
<b>Body Type</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'body_type_id',CHtml::listData(BodyType::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Body Type--','class'=>'parent_form_elements')); ?>
<div id="body_type_error"></div>
</td>
</tr>


<tr>
<td>
</td>
<td>
<?php
if($model->photo!=""){
	?>
    <?php echo CHtml::image(Yii::app()->request->baseUrl.'/cars/'.$model->photo,"advert",array("width"=>100,"height"=>100,'class'=>'parent_form_elements')); ?> 
    <?php
}
?>
<input name="cars_hidden" id="cars_hidden" type="hidden" class="parent_form_elements" value="<?php echo $model->photo;?>" /> 
</td>
</tr>


<tr>
<td>
<b>Car Photo</b>
</td>
<td>
<?php echo CHtml::activeFileField($model, 'photo',array('class'=>'parent_form_elements')); ?>
<div id="photo_error"></div>
</td>
</tr>

<tr>
<td>
<b>Year</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'year_id',CHtml::listData(CarYears::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Year--','class'=>'parent_form_elements'));
?>
<div id="car_year_error"></div>
</td>
</tr>


<tr>
<td>
<b>Chasis No.</b>
</td>
<td>
<?php echo $form->textField($model,'chasis_number',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements')); ?>
<div id="chasis_number_error"></div>
</td>
</tr>


<tr>
<td>
<b>Engine No.</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'engine_id',CHtml::listData(Engines::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Engine Number--','class'=>'parent_form_elements'));
?>
<div id="engine_number_error"></div>
</td>
</tr>


<tr>
<td>
<b>Consumption (KM/L)</b>
</td>
<td>
<?php echo $form->textField($model,'consumption',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements pure_numeric_fields_dot')); ?>
<div id="consumption_error"></div>
</td>
</tr>

<tr>
<td>
<b>Fuel type</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'fuel_type',array(''=>'--Select Fuel Type--','Diesel'=>'Diesel','Petrol'=>'Petrol'),array('class'=>'parent_form_elements')); ?>
<div id="fuel_type_error"></div>
</td>
</tr>

<tr>
<td>
<b>Millage</b>
</td>
<td>
<?php echo $form->textField($model,'millage',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements pure_numeric_fields_dot')); ?>
<div id="millage_error"></div>
</td>
</tr>

<tr>
<td>
<b>Country of Origin</b>
</td>
<td>
<?php echo $form->textField($model,'country',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements pure_letters_fields')); ?>
<div id="country_error"></div>
</td>
</tr>

<tr>
<td>
<b>Tyre Size</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'tyre_id',CHtml::listData(Tyres::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Tyre--','class'=>'parent_form_elements'));
?>
<div id="tire_size_error"></div>
</td>
</tr>


<tr>
<td>
<b>Last Service Date</b>
</td>
<td>
<?php
	$this->widget('ext.my97DatePicker.JMy97DatePicker',array(
	'name'=>CHtml::activeName($model,'last_service_date'),
	'value'=>$model->last_service_date,
	'options'=>array('dateFmt'=>'yyyy-MM-dd'),
 ));
?>
<div id="last_service_date_error"></div>
</td>
</tr>

<tr>
<td>
<b>Last Service Millage</b>
</td>
<td>
<?php echo $form->textField($model,'last_service_millage',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements pure_numeric_fields_dot')); ?>
<div id="last_service_millage_error"></div>
</td>
</tr>

<tr>
<td>
<b>Insurance Exp. Date</b>
</td>
<td>
<?php
	$this->widget('ext.my97DatePicker.JMy97DatePicker',array(
	'name'=>CHtml::activeName($model,'insurance_exp_date'),
	'value'=>$model->insurance_exp_date,
	'options'=>array('dateFmt'=>'yyyy-MM-dd'),
 ));
?>
<div id="insurance_exp_date_error"></div>
</td>
</tr>


<tr>
<td>
<b>Serice Millage</b>
</td>
<td>
<?php echo $form->textField($model,'service_millage',array('size'=>50,'maxlength'=>50,'class'=>'parent_form_elements pure_numeric_fields_dot')); ?>
<div id="service_millage_error"></div>
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
<?php echo $form->hiddenField($CarPhysicalDamages,'car_id',array('size'=>50,'maxlength'=>50,'value'=>$model->id)); ?>
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
<?php echo $form->hiddenField($CarMechanicalIssues,'car_id',array('size'=>50,'maxlength'=>50,'value'=>$model->id)); ?>
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
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200,'class'=>'parent_form_elements')); ?>
<?php //echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array('class'=>'parent_form_btn')); ?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostCars()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">	
//$(".pure_numeric_fields").numeric();
//$(".pure_numeric_fields_dot").numeric({allow:"."});
$("#Cars_consumption").numeric();
$('.pure_letters_fields').alpha();
$("#Cars_millage").numeric();


function SaveSubDetails(type)
{
	if(type=='Physical'){
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
	}else if(type=='Mechanical'){
		
		var url='<?php echo Yii::app()->controller->createUrl('Cars/saveMechanicalIssues');?>';
		var CarMechanicalIssues_photo=$("#CarMechanicalIssues_photo").val();
		var mechanical_issues_hidden=$("#mechanical_issues_hidden").val();
		var CarMechanicalIssues_description=$("#CarMechanicalIssues_description").val();
		var CarMechanicalIssues_car_id=parseInt($("#CarMechanicalIssues_car_id").val());
		
		if(mechanical_issues_hidden=="" && CarMechanicalIssues_photo=="")
		{
			var ext="";
		}else if(mechanical_issues_hidden!="" && CarMechanicalIssues_photo=="")
		{
			var ext="jpg";
		}else if(mechanical_issues_hidden=="" && CarMechanicalIssues_photo!="")
		{
			var ext = CarMechanicalIssues_photo.split('.').pop().toLowerCase(); 
		}else{
			var ext = CarMechanicalIssues_photo.split('.').pop().toLowerCase();
		}
		
		
if(ext=="png" || ext=="jpg" || ext=="jpeg"){
	$("#Mechanical_photo_error").removeClass('error').html('').hide();
	if(CarMechanicalIssues_description!==""){
		$("#Mechanical_description_error").removeClass('error').html('').hide();
		if(CarMechanicalIssues_car_id>0){
			postSubdetailsForm(url,type,CarMechanicalIssues_car_id);
		}
	}else{
		$("#Mechanical_description_error").addClass('error').html('Please describe the photo above.').show();
		$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
	}
}else{
	$("#Mechanical_photo_error").addClass('error').html("Please upload the mechanical issues photo as(.JPG or PNG)").show();
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}
	}
}


function getPhysicalDamages(car_id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getPhysicalDamages');?>",
	type: "POST",
	dataType: "html",
	data: {'car_id' : car_id},
	beforeSend: function(){
		$("#physical_damages_content_preloading_div").show();
	}
	}).done(function(html){
		$("#physical_damages_content_preloading_div").hide();
		$("#physical_damages_content_section").html(html).show();
	});		
}


function getMechanicalIssues(car_id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getMechanicalIssues');?>",
	type: "POST",
	dataType: "html",
	data: {'car_id' : car_id},
	beforeSend: function(){
		$("#Mechanical_content_preloading_div").show();
	}
	}).done(function(html){
		$("#Mechanical_content_preloading_div").hide();
		$("#Mechanical_content_section").html(html).show();
	});
}


function postSubdetailsForm(url,type,car_id)
{	
if(type=='Physical'){
	$("#physical_damages_preloading_div").show();
}else if(type=='Mechanical'){
	$("#mechanical_issues_preloading_div").show();
}
/*Start submit the form*/
var formData = new FormData($("#cars-form")[0]);				
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
		$("#CarPhysicalDamages_photo").val('');
		$("#CarPhysicalDamages_description").val('');
		//End reset values
		$("#physical_damages_info_div").addClass('success').removeClass('error').html('Physical damages details successfully saved.').show();
		getPhysicalDamages(car_id);
		
		}else if(type=='Mechanical'){
		//Reset values
		$("#CarMechanicalIssues_photo").val('');
		$("#CarMechanicalIssues_description").val('');
		//End reset values
		$("#mechanical_issues_info_div").addClass('success').removeClass('error').html('Mechanical issues successfully saved.').show();
		getMechanicalIssues(car_id);
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
	$("#CarPhysicalDamages_photo").val('');
	$("#CarPhysicalDamages_description").val('');
	$("#physical_damages_photo_error").removeClass('error').html('').hide();
	$("#physical_damages_description_error").removeClass('error').html('').hide();

}

$('#Cars_no_physical_damages').change(function(){
    var checked = this.checked ? 'yes' : 'no';
	if(checked=='yes'){
		$(".physical_damages_fields_section").hide();
		$("#damages_attachment").hide();
		$("#damages_attachment_hide").hide();
		$("#CarPhysicalDamages_photo").val('');
		$("#CarPhysicalDamages_description").val('');
		$("#Cars_physical_damages").val('').attr('disabled',true);
		$("#physical_damages_photo_error").removeClass('error').html('').hide();
		$("#physical_damages_description_error").removeClass('error').html('').hide();
		$("#physical_damages_error").removeClass('error').html('').hide();
	}else{
		$("#Cars_physical_damages").val('').attr('disabled',false);
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
	$("#CarMechanicalIssues_photo").val('');
	$("#CarMechanicalIssues_description").val('');
	$("#Mechanical_photo_error").removeClass('error').html('').hide();
	$("#Mechanical_description_error").removeClass('error').html('').hide();
}


$('#Cars_no_mechanical_issues').change(function(){
    var checked = this.checked ? 'yes' : 'no';
	if(checked=='yes'){
		$(".Mechanical_fields_section").hide();
		$("#mechanical_attachment").hide();
		$("#mechanical_attachment_hide").hide();
		$("#CarMechanicalIssues_photo").val('');
		$("#CarMechanicalIssues_description").val('');
		$("#Cars_mechanical_issues").val('').attr('disabled',true);
		$("#Mechanical_photo_error").removeClass('error').html('').hide();
		$("#Mechanical_description_error").removeClass('error').html('').hide();
		$("#mechanical_issues_error").removeClass('error').html('').hide();
	}else{
		$("#Cars_mechanical_issues").val('').attr('disabled',false);
	}
});


<?php
if($model->isNewRecord){
?>
$('#Cars_model_id').prop("disabled", true);
<?php
}
?>
highlightMenu('Cars');
function defaultModels()
{
	$('option', '#Cars_model_id').remove();
	default_values = { "0": "--Select Car Model--"};
	$.each(default_values, function(key, value) {   
			$('#Cars_model_id')
			.append($('<option>', { value : key })
			.text(value)); 
			});
}


function getModels(obj)
{
	defaultModels();
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getModels');?>",
	type: "POST",
	dataType: "html",
	data: {'make_id' : value},
	beforeSend: function(){
		$("#car_model_preloader_div").show();
	}
	}).done(function(html){
		var selectValues=jQuery.parseJSON(html);
		if (jQuery.isEmptyObject(selectValues))
		{
			$("#car_model_preloader_div").fadeOut(200,function(){
			$('#Cars_model_id').prop("disabled", true);
			});	
		}else{
			$.each(selectValues, function(key, value) {   
			$('#Cars_model_id')
			.append($('<option>', { value : key })
			.text(value)); 
				$("#car_model_preloader_div").fadeOut(200,function(){
					$('#Cars_model_id').prop("disabled", false);
				});	
			});	
		}	
	});	
}


function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function PostCars()
{	
	var current_task=$("#current_task").val();
	var Cars_number_plate=$("#Cars_number_plate").val();
	var Cars_make_id=$("#Cars_make_id").val();
	var Cars_model_id=parseInt($("#Cars_model_id").val());
	var Cars_body_type_id=$("#Cars_body_type_id").val();
	var Cars_photo=$("#Cars_photo").val();
	var cars_hidden=$("#cars_hidden").val();
	var Cars_year_id=parseInt($("#Cars_year_id").val());
	var Cars_chasis_number=$("#Cars_chasis_number").val();
	var Cars_engine_id=parseInt($("#Cars_engine_id").val());
	var Cars_consumption=$("#Cars_consumption").val();
	var Cars_fuel_type=$("#Cars_fuel_type").val();
	var Cars_millage=$("#Cars_millage").val();
	var Cars_country=$("#Cars_country").val();
	var Cars_tyre_id=parseInt($("#Cars_tyre_id").val());
	var Cars_last_service_date=$("#Cars_last_service_date").val();
	var Cars_last_service_millage=$("#Cars_last_service_millage").val();
	var Cars_insurance_exp_date=$("#Cars_insurance_exp_date").val();
	var Cars_service_millage=$("#Cars_service_millage").val();
	var Cars_physical_damages=$("#Cars_physical_damages").val();
	var Cars_no_physical_damages=$('#Cars_no_physical_damages').is(':checked');
	var Cars_mechanical_issues=$("#Cars_mechanical_issues").val();
	var Cars_no_mechanical_issues=$('#Cars_no_mechanical_issues').is(':checked');
	var Cars_status=$("#Cars_status").val();
	var Cars_spare_tire=$("#Cars_spare_tire").val();
	
	
	
	if(cars_hidden=="" && Cars_photo=="")
	{
		var cover_photo_ext="";
	}else if(cars_hidden!="" && Cars_photo=="")
	{
		var cover_photo_ext="jpg";
	}else if(cars_hidden=="" && Cars_photo!="")
	{
		var cover_photo_ext = Cars_photo.split('.').pop().toLowerCase(); 
	}else{
		var cover_photo_ext = Cars_photo.split('.').pop().toLowerCase();
	}


if(Cars_number_plate!==""){
	$("#number_plate_error").removeClass('error').html('').hide();
	if(Cars_make_id!==""){
		$("#car_make_error").removeClass('error').html('').hide();
		if(Cars_model_id>0){
			$("#car_model_error").removeClass('error').html('').hide();
			if(Cars_body_type_id!==""){
				$("#body_type_error").removeClass('error').html('').hide();
				if(cover_photo_ext=="png" || cover_photo_ext=="jpg" || cover_photo_ext=="jpeg"){
					$("#photo_error").removeClass('error').html('').hide();
					if(Cars_year_id>0){
					 	$("#car_year_error").removeClass('error').html('').hide();
						if(Cars_chasis_number!==""){
							$("#chasis_number_error").removeClass('error').html('').hide();
							if(Cars_engine_id>0){
								$("#engine_number_error").removeClass('error').html('').hide();
								if(Cars_consumption!==""){
									$("#consumption_error").removeClass('error').html('').hide();
									if(Cars_fuel_type!==""){
										$("#fuel_type_error").removeClass('error').html('').hide();
										if(Cars_millage!==""){
											$("#millage_error").removeClass('error').html('').hide();
											if(Cars_country!==""){
												$("#country_error").removeClass('error').html('').hide();
												if(Cars_tyre_id>0){
													$("#tire_size_error").removeClass('error').html('').hide();
													
													
if(Cars_last_service_date!==""){
	$("#last_service_date_error").removeClass('error').html('').hide();
	if(Cars_last_service_millage!==""){
		$("#last_service_millage_error").removeClass('error').html('').hide();
		if(Cars_insurance_exp_date!==""){
			$("#insurance_exp_date_error").removeClass('error').html('').hide();
			if(Cars_service_millage!==""){
				$("#service_millage_error").removeClass('error').html('').hide();
				if((Cars_physical_damages!=="") ||  (Cars_physical_damages=="" && Cars_no_physical_damages==true)){
					$("#physical_damages_error").removeClass('error').html('').hide();
					if((Cars_mechanical_issues!=="") ||  (Cars_mechanical_issues=="" && Cars_no_mechanical_issues==true)){
						$("#mechanical_issues_error").removeClass('error').html('').hide();
						if(Cars_status!==""){
							$("#status_error").removeClass('error').html('').hide();
							
				/*Start submit the form*/
				$(".dropDownElements").prop("disabled", false);
				$("#save_preloader_div").show();
				$("#cars-form").ajaxForm({
				dataType:'html',
				success: function (response){
				$("#save_preloader_div").fadeOut(500);
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
				// split the response and enable/ disable the relevant fields.
				var parts = response.split(" ",3);
				if(parseInt(parts[0])==0){
				$("#damages_attachment").show();
				$("#CarPhysicalDamages_car_id").val(parts[2]);
				}else{
				$("#damages_attachment").hide();
				$("#CarPhysicalDamages_car_id").val('');
				}
				if(parseInt(parts[1])==0){
				$("#mechanical_attachment").show();
				$("#CarMechanicalIssues_car_id").val(parts[2]);
				}else{
				$("#mechanical_attachment").hide();
				$("#CarMechanicalIssues_car_id").val('');
				}
				
				//$("#Cars_id").val(response);
				//$('#cars-form')[0].reset();
				//$('#Cars_model_id').prop("disabled", true);
				$('.parent_form_elements').prop("disabled", true);
				$('.parent_form_btn').hide().prop("type", "button");
				
				$("#info_frm").addClass('success').removeClass('error').html('Car successfully added.').show();
				}else if(current_task=='Update'){
				$("#info_frm").addClass('success').removeClass('error').html('Car successfully updated.').show();
				}
				}
				}
				}).submit();
				/*End submit the form*/		

				
				
				
						}else{
							displayError("Please select the status.",'status_error');
							}
					}else{
						displayError("Please enter the car's mechanical issues.",'mechanical_issues_error');
					}
				}else{
					displayError("Please enter the car's physical damages.",'physical_damages_error');
				}
			}else{
				displayError("Please enter the car service millage.",'service_millage_error');
			}
		}else{
			displayError("Please enter the insurance expiry date.",'insurance_exp_date_error');	
		}
	}else{
		displayError("Please enter the last service millage.",'last_service_millage_error');
	}
}else{
	displayError("Please enter the last service date.",'last_service_date_error');
}



												}else{
													displayError("Please enter the tire size.",'tire_size_error');
												}
											}else{
												displayError("Please enter the country.",'country_error');	
											}
										}else{
											displayError("Please enter the millage.",'millage_error');	
										}
									}else{
										displayError("Please select the fuel type.",'fuel_type_error');
									}
								}else{
									displayError("Please enter the consumption.",'consumption_error');
								}
							}else{
								displayError("Please enter the engine number.",'engine_number_error');
							}
						}else{
							displayError("Please enter the chasis number.",'chasis_number_error');
						}
					}else{
						displayError("Please enter the year.",'car_year_error');
					}
				}else{
					displayError("Please upload the car's photo as(.JPG or PNG)",'photo_error');
				}
			}else{
				displayError('Please select the body type.','body_type_error');
			}
		}else{
			displayError('Please select the car model.','car_model_error');
		}
	}else{
		displayError('Please select the car make.','car_make_error');
	}
}else{
	displayError('Please enter the registration number.','number_plate_error');
}	
}

	


function DeleteRecord(controller,id,car_id)
{
	if(controller==1){
		var delete_controller='CarMechanicalIssues';
		
	}else if(controller==2){
		var delete_controller='CarPhysicalDamages';
	}
	
	var path="index.php?r="+delete_controller+"/delete&id="+id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			if(controller==1){
				getMechanicalIssues(car_id);
			}else if(controller==2){
				getPhysicalDamages(car_id);
			}
		});		
}


$(document).ready(function(){
		var no_mechanical_issues=parseInt(<?php echo $model->no_mechanical_issues;?>);
		var no_physical_damages=parseInt(<?php echo $model->no_physical_damages;?>);
		
		if(no_physical_damages==1)
		{
			$("#Cars_physical_damages").val('').attr('disabled',true);
		}else{
			$("#Cars_physical_damages").attr('disabled',false);
		}
		
		if(no_mechanical_issues==1)
		{
			$("#Cars_mechanical_issues").val('').attr('disabled',true);
		}else{
			$("#Cars_mechanical_issues").attr('disabled',false);
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
			PostCars();
		}
	});
	
</script>
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
    <h3>Add Fuel Request</h3>
    <?php
}else{
	?>
    <h3>Update Fuel Request </h3>
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
    <b>Fuel request for car- <?php echo $CarsData->number_plate;?></b><br><br>
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
<td width="138">
<b>Request on behalf of</b>
</td>
<td>
<?php
$Carsdata = array();
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$assignments=CarAssignment::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY."");
?>

<?php
foreach ($assignments as $item){
	$Cars=Cars::model()->findByPk($item->car_id);
	$CarMake=CarMake::model()->findByPk($Cars->make_id);
	$CarModels=CarModels::model()->findByPk($Cars->model_id);
	$Users=Users::model()->findByPk($item->user_id);
	$Carsdata[$Cars->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") Assigned to ".$Users->first_name." ".$Users->last_name; 
	//$Cars->millage
	?>
    <input type="hidden" id="hiddenPrevvalues_<?php echo $Cars->id;?>" value="<?php echo $Cars->millage;?>" class="hiddenPrevvalues">
    <?php
}
echo CHtml::activeDropDownList($model, 'car_id', $Carsdata ,array('empty' => '--Request on behalf of--','onchange'=>'setPreviousMillage(this)'));
?>
<div id="car_error"></div>
</td>
</tr>
    <?php
}
?>

<tr>
<td>
<b>Previous Millage (KM)</b>
</td>
<td>
<?php
if($COMPANY_SUB_USER_ROLE=='Driver'){
	echo $form->hiddenField($model,'previous_millage',array('size'=>50,'maxlength'=>50,'value'=>intval($CarsData->millage)));
}else if($COMPANY_SUB_USER_ROLE=='TM'){
	echo $form->hiddenField($model,'previous_millage',array('size'=>50,'maxlength'=>50));
}
?>

<div class="prevMillage" id="prevMillage">
<?php if($model->isNewRecord){ 
	echo $CarsData->millage;
}
else{ 
	echo $model->car->millage;
}
?>
</div>


<div id="previous_millage_error"></div>
</td>
</tr>


<tr>
<td>
<b>Current Millage (KM)</b>
</td>
<td>
<?php echo $form->textField($model,'current_millage',array('size'=>50,'maxlength'=>50)); ?>
<div id="current_millage_error"></div>
</td>
</tr>




<tr>
<td>
<b>Fuel Quantity (Litters)</b>
</td>
<td>
<?php echo $form->textField($model,'fuel_quantity',array('size'=>50,'maxlength'=>50)); ?>
<div id="fuel_quantity_error"></div>
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

<?php /*?><a href="javascript:void(0);" class="attachment_link" id="damages_attachment" onClick="ShowFields()"><?php echo $clip_img;?></a>
<a href="javascript:void(0);" class="attachment_link" id="damages_attachment_hide" onClick="HideFields()"><?php echo $close_img;?></a><?php */?>

</td>
</tr>

<tr>
<td></td>
<div id="sub_details_content_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>
<td id="sub_details_content_section"></td>
</tr>



<?php /*?><tr class="description_fields_section">
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
<?php */?>





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
<?php echo $form->hiddenField($model,'request_type',array('size'=>60,'maxlength'=>200,'value'=>'fuel')); ?>
<?php
if($COMPANY_SUB_USER_ROLE=='Driver')
{
	echo $form->hiddenField($model,'car_id',array('size'=>60,'maxlength'=>200,'value'=>intval($UsersData->car_id)));
	//echo $form->textField($model,'company_id',array('size'=>60,'maxlength'=>200,'value'=>intval($UsersData->company_id)));
}
?>
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostFuel()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>

</td>
</tr>
</table>
    <?php
}else{
	?>
    <div class="error">You do not have a car assigned to you at the moment thus you cannot raise a fuel request</div>
    <?php
}
?>
<?php $this->endWidget(); ?>
</div>
<script language="javascript" type="text/javascript">
$("#Requests_current_millage").numeric();
$("#Requests_fuel_quantity").numeric();

function setPreviousMillage(obj)
{
	if(obj.options[obj.selectedIndex].value!='')
	{
		var value=parseInt(obj.options[obj.selectedIndex].value);
		var text=obj.options[obj.selectedIndex].text;
		var previousMillage=parseInt($("#hiddenPrevvalues_"+value).val());
		$("#prevMillage").html(previousMillage);
		$("#Requests_previous_millage").val(previousMillage);
	}else{
		$("#prevMillage").html('');
		$("#Requests_previous_millage").val('');
	}
}

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
		$("#sub_details_info_div").addClass('success').removeClass('error').html('Fuel Request details successfully saved.').show();
		getRequestSubDetails(RequestSubDetails_request_id);
	}else{
		$("#sub_details_info_div").addClass('error').removeClass('success').html('Error Fuel Request details.').show();
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
highlightMenu('Fuel Request');


function PostFuel()
{
	var role='<?php echo $COMPANY_SUB_USER_ROLE;?>';
	var current_task=$("#current_task").val();	
	var Requests_car_id=parseInt($("#Requests_car_id").val());
		<?php
		if($COMPANY_SUB_USER_ROLE=='Driver'){
			if($model->isNewRecord){
			?>
				var Requests_previous_millage=parseInt(<?php echo $CarsData->millage;?>);
			<?php
			}
			else{
			?>
				var Requests_previous_millage=parseInt(<?php echo $model->car->millage;?>);
			<?php
		}
		?>
	
	<?php
	}else if($COMPANY_SUB_USER_ROLE=='TM'){
	?>
	var Requests_previous_millage=parseInt($("#hiddenPrevvalues_"+Requests_car_id).val());
	<?php
	}
	?>
	var Requests_current_millage=parseInt($("#Requests_current_millage").val());
	var Requests_fuel_quantity=parseInt($("#Requests_fuel_quantity").val()); 
	var Requests_description=$("#Requests_description").val();
	var Requests_no_description=$('#Requests_no_description').is(':checked');
	var Requests_status=parseInt($("#Requests_status").val());
if(Requests_car_id>0 && role=='TM' || role=='Driver'){
		$("#car_error").removeClass('error').html('').hide();
	if(Requests_previous_millage>0){
		$("#previous_millage_error").removeClass('error').html('').hide();
		if(Requests_current_millage>0){
			$("#current_millage_error").removeClass('error').html('').hide();
			if(Requests_current_millage>Requests_previous_millage){
				$("#current_millage_error").removeClass('error').html('').hide();
				$("#previous_millage_error").removeClass('error').html('').hide();
				if(Requests_fuel_quantity>0){
					$("#fuel_quantity_error").removeClass('error').html('').hide();
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
					$('.parent_fields').val('');
					$("#Requests_subsystem_id").val('');
					//End reset parent form values
					$("#Requests_description").val('').attr('disabled',false);
					$('#requests-form')[0].reset();
					$(".prevMillage").html('');
					$("#info_frm").addClass('success').removeClass('error').html('Fuel Request successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Fuel Request successfully updated.').show();
					}
					}
					}
					}).submit();
					/*End submit the form*/
					
					
				}else{
					displayError("Please select the status.","status_error")
				}
			}else{
				displayError("Please enter the request description.","description_error")
			}
				}else{
					displayError("Please enter the fuel quantity you are requesting for.","fuel_quantity_error")
				}
			}else{
				displayError("Current Millage cannot be less than the previous millage.","current_millage_error");
				//displayError("Previous Millage cannot be greater than the current millage.","previous_millage_error");
			}
		}else{
			displayError("Please enter the current millage.","current_millage_error");
		}
	}else{
		//displayError("Please enter the previous millage.","previous_millage_error");
	}}else{
		displayError("Please select who you are requesting on behalf.","car_error");
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
			PostFuel();
		}
	});
</script>
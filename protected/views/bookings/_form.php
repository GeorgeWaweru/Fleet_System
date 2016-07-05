<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bookings-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); 

$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) :0;
$clip_img=CHtml::image('images/clip.png');
$close_img=CHtml::image('images/close.png');
if(isset($_REQUEST['rid']))
{
	$rid=isset($_REQUEST['rid']) ? intval(base64_decode($_REQUEST['rid'])) :0;
}else{
	$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) :0;
	$Bookings=Bookings::model()->findByPk($id);
	$rid=$Bookings->request_id;
}
$type=isset($_REQUEST['type']) ? base64_decode($_REQUEST['type']) :'';
if($type=='service' || $type=='repair')
{
	$final_type=$type;
}else{
	$final_type='';
}
?>
<h2>Request Details</h2>
<?php
$BookingsModel=new Bookings;
$Requests=Requests::model()->findByPk($rid);
$details=RequestSubDetails::model()->findAllByAttributes(array('request_id'=>$model->request_id));
$user_id=$Requests->user_id;
$car_id=$Requests->car_id;
$company_id=$Requests->company_id;
$system_id=$Requests->system_id;
$subsystem_id=$Requests->subsystem_id;
$description=$Requests->description;
$no_description=$Requests->no_description;
$created_at=$Requests->created_at;
?>

<table>
<tr height="30">
<td width="90">
<b>Company</b>
</td>
<td>
<?php
$Companies=Companies::model()->findByPk($company_id);
echo $Companies->title;
?>
</td>
</tr>


<tr height="30">
<td>
<b>Car</b>
</td>
<td>
<?php
$Cars=Cars::model()->findByPk($car_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);
echo  $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")";
?>
</td>
</tr>


<tr height="30">
<td>
<b>Request Type</b>
</td>
<td>
<?php echo ucfirst($Requests->request_type); ?> Request
</td>
</tr>

<tr height="30">
<td>
<b>System</b>
</td>
<td>
<?php
$System=System::model()->findByPk($system_id);
echo $System->title;
?>
</td>
</tr>

<tr height="30">
<td>
<b>Sub System</b>
</td>
<td>
<?php
$SubSystem=SubSystem::model()->findByPk($subsystem_id);
echo $SubSystem->title;
?>
</td>
</tr>


<?php
if($no_description==0)
{
	?>
    <tr height="30">
    <td>
    <b>Description</b>
    </td>
    <td>
    <?php
    echo $description;
    ?>
    </td>
    </tr>
    <?php
}
?>
</table>

<?php

if(count($details)>0)
{
	?>
    <table>
    <?php
	foreach($details as $detail)
	{
		?>
        <tr>
        <td>
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/requests/'.$detail->photo,$name,array("class"=>"banner_class","width"=>"100px"));?></td>
        <td><?php echo $detail->description;?></td>
        </tr>
        <?php
	}
	?>
    </table>
    <?php
}
?>



<table>
<tr>
<td width="60">
<b>Request</b>
</td>
<td>

<?php
if(intval($model->isNewRecord)==1)
{
$Requests=Requests::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY." AND request_type='$type' AND id=".$rid."");
$DropDownData = array();
foreach ($Requests as $item){
$Cars=Cars::model()->findByPk($item->car_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);
$System=System::model()->findByPk($item->system_id);
$SubSystem=SubSystem::model()->findByPk($item->subsystem_id);
$text = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") -".$System->title." / ".$SubSystem->title;
$DropDownData[$item->id]=$text; 
}
echo CHtml::activeDropDownList($model, 'request_id', $DropDownData ,array('disabled' => 'disabled','class'=>'parent_form_elements'));
}else{
$Requests=Requests::model()->findByPk($model->request_id);
$DropDownData = array();
$Cars=Cars::model()->findByPk($Requests->car_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);
$System=System::model()->findByPk($Requests->system_id);
$SubSystem=SubSystem::model()->findByPk($Requests->subsystem_id);
$text = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") -".$System->title." / ".$SubSystem->title;
$DropDownData[$Requests->id]=$text; 
echo CHtml::activeDropDownList($model, 'request_id', $DropDownData ,array('disabled' => 'disabled','class'=>'parent_form_elements'));
}
?>
<div id="request_error"></div>
</td>
</tr>

<tr>
<td>
<b>Supplier</b>
</td>
<td>
<?php
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND']:'';
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']):0;

if($LOGGED_IN_USER_KIND=='supplier')
{
	$Suppliers=Suppliers::model()->findByPk($LOGGED_IN_USER_ID);
	$DropDownData = array();
	
	$SupplierSystems=SupplierSystems::model()->findAllByAttributes(array('supplier_id'=>$Suppliers->id,'status'=>1)); 
	$text=$Suppliers->title." -Dealers in(  ";
	$counter=0;
	foreach($SupplierSystems as $SupplierSystem)
	{
		$System=System::model()->findByPk($SupplierSystem->system_id);
		if($counter<count($SupplierSystems)-1)
		{
			$text=$text.$System->title.",";
		}else{
			$text=$text.$System->title." )";
		}
		$counter++;
	}
	$DropDownData[$Suppliers->id]=$text; 
	echo CHtml::activeDropDownList($model, 'supplier_id', $DropDownData,array('disabled' => 'disabled','class'=>'parent_form_elements'));
}else{
$Suppliers=Suppliers::model()->findAll("status='1' AND is_default='0'");
$DropDownData = array();
foreach ($Suppliers as $item){
$SupplierSystems=SupplierSystems::model()->findAllByAttributes(array('supplier_id'=>$item->id,'status'=>1)); 
$text=$item->title." -Dealers in(  ";
$counter=0;
foreach($SupplierSystems as $SupplierSystem)
{
	$System=System::model()->findByPk($SupplierSystem->system_id);
	if($counter<count($SupplierSystems)-1)
	{
		$text=$text.$System->title.",";
	}else{
		$text=$text.$System->title." )";
	}
	$counter++;
}
$DropDownData[$item->id]=$text; 
}
echo CHtml::activeDropDownList($model, 'supplier_id', $DropDownData ,array('empty' => '--Select Supplier--'));
}

?>
<div id="supplier_error"></div>
</td>
</tr>


<?php
if($LOGGED_IN_USER_KIND!='supplier')
{
	?>
    <tr>
    <td>
    <b>Status</b>
    </td>
    <td>
    <?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
    <div id="status_error"></div>
    </td>
    </tr>
    <?php
}
?>



<tr>
<td></td>
<td>
<input type="hidden" id="current_task" name="current_task" value="<?php if($model->isNewRecord){ echo 'Add';}else{ echo 'Update'; } ?>">
<?php echo $form->hiddenField($model,'id',array('size'=>60,'maxlength'=>200)); ?>

<?php
if(intval($model->isNewRecord)==1)
{
	 echo $form->hiddenField($model,'request_type',array('size'=>60,'maxlength'=>200,'value'=>$final_type));
}else{
	 echo $form->hiddenField($model,'request_type',array('size'=>60,'maxlength'=>200));
}
?>


<?php
if($LOGGED_IN_USER_KIND!='supplier'){
	?>
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostBooking()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
    <?php
	
}
?>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->

<div class="booking_comments_section" id="booking_comments_section"></div>
<div id="comments_preloading_div" class="preloader_div"><img src="images/loader.gif" /></div>

<?php
$BookingComments=new BookingComments
?>
<form id="booking_comments_frm" method="post" action="<?php echo Yii::app()->controller->createUrl('BookingComments/Create');?>" class="booking_comments_frm" enctype="multipart/form-data" autocomplete="off">
<a href="javascript:void(0);" class="add_comment" id="add_comment" onClick="showSpares()">Add Comment</a><br>
<a href="javascript:void(0);" class="hide_comment" id="hide_comment" onClick="hideSpares()"><?php echo $close_img;?> Close Comment</a><br><br>

<div class="comments_section" id="comments_section">
<b>Comment</b><br>
<?php echo $form->textArea($BookingComments,'comment',array('rows'=>10, 'cols'=>50)); ?><br><br>
<div id="BookingComments_comment_error"></div>


<?php
if($LOGGED_IN_USER_KIND=="supplier"){
?>
<br>
<a href="javascript:void(0);" class="add_all_spares" id="add_all_spares" onClick="showAllSpares()">Attach Spare Parts</a>
<a href="javascript:void(0);" class="hide_all_spares" id="hide_all_spares" onClick="hideAllSpares()"><?php echo $close_img;?> Close Spare Parts</a>
<br><br>
<div id="spare_parts_section" class="spare_parts_section">
<b>Select Required Spare Parts</b><br>
<?php
$Spare=Spare::model()->findAllByAttributes(array('sub_system_id'=>$subsystem_id)); 
if(count($Spare)>0)
{
?>

<table>
<?php
$BookingSparesModel=new BookingSpares;
foreach($Spare as $item)
{
?>
<tr>
<td>
<input type="checkbox" class="spare_parts_cks" id="spare_parts_cks_<?php echo $item->id;?>" onClick="enableSpareCostField(<?php echo $item->id;?>)" name="spare_parts[]" value="<?php echo $item->id;?>"><?php echo $item->title;?>
</td>
<td>
<span class="cost_title">Cost (KSHs)</span>
<input type="text" class="cost_field_element" disabled name="spare_cost[]" id="spare_cost_<?php echo $item->id;?>"><br>
<div class="spares_error_div" id="error_spare_cost_<?php echo $item->id;?>"></div>
</td>
<td>
<span class="photo_title">Photo</span>
<input type="file" class="spares_image_element" disabled name="spares_image[]" id="spares_image_<?php echo $item->id;?>">


<?php /*?><?php
$uploadId="spares_image_".$item->id;
?>
<?php echo CHtml::activeFileField($BookingSparesModel, 'spare_photo',array('class'=>'spares_image_element','id'=>$uploadId,'disabled'=>'disabled')); ?><?php */?>
<br>
<div class="spares_image_error_div" id="error_spare_image_<?php echo $item->id;?>"></div>
</td>
</tr>
<?php
}
?>
</table>
<?php
}
?>
<div id="spares_listing_error"></div>
</div>


<br>
<a href="javascript:void(0);" class="add_more_spares" id="add_more_spares" onClick="showMoreSpares()">Attach More Spare Parts</a>
<a href="javascript:void(0);" class="hide_more_spares" id="hide_more_spares" onClick="hideMoreSpares()"><?php echo $close_img;?> Close More Spare Parts</a><br>
<br><br>
<div id="more_spare_parts_section" class="more_spare_parts_section">
<table>
<tr>
<td>
<b>System</b>
</td>
<td>
<select name="systems" id="systems" onChange="getSubSystem(this)">
<option>--Select System--</option>
<?php
$request_type=ucfirst($Requests->request_type);;
$System=System::model()->findAll("status=1 AND service_type='$request_type' AND is_default=0");
foreach($System as $item)
{
	?>
    <option value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
    <?php
}
?>
</select>
<div id="system_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="system_error"></div>
</td>
</tr>

<tr class="subSystemSection" id="subSystemSection">
<td>
<b>Sub System</b>
</td>
<td>
<select name="sub_system" id="sub_system" onChange="getSpares(this)">
</select>
<div id="sub_system_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="sub_system_error"></div>
</td>
</tr>



<tr>
<td colspan="2" id="more_spares_ajax_section" align="center"></td>
</tr>



</table>
<div id="more_spares_listing_error"></div>
</div>

    <?php	
}
?>




<input type="hidden" id="hidden_booking" name="hidden_booking" value="<?php echo $model->id;?>">

<input type="hidden" id="sparesErrorCount" name="sparesErrorCount" value="0">
<input type="hidden" id="MoreSparesErrorCount" name="MoreSparesErrorCount" value="0">

<input type="button" id="save" onClick="SaveBookingDetails()" value="Save">
<br><br>
<div id="preloader_login_div" class="preloader_div"><img src="images/loader.gif" /></div>
<br>
<div id="booking_details_info_div"></div>
</div>
</form>


<div id="additional_spares_section" class="additional_spares_section"></div>


<script language="javascript" type="text/javascript">
$('#sub_system').prop("disabled", true);

function AddMoreSpares()
{
	validateMoreSpareParts();
	var MoreSparesErrorCount= parseInt($("#MoreSparesErrorCount").val());
	if(MoreSparesErrorCount==0)
	{
		
	}
}


function enableSpareCostField(id)
{
	var spare_parts_cks=$('#spare_parts_cks_'+id).is(':checked');
	if(spare_parts_cks==true)
	{
		$('#spare_cost_'+id).prop("disabled", false);	
		$('#spares_image_'+id).prop("disabled", false);	
	}else{
		$('#spare_cost_'+id).val('').prop("disabled", true);
		$('#spares_image_'+id).val('').prop("disabled", true);
		$('#error_spare_cost_'+id).removeClass('error').html('').hide();
		$('#error_spare_image_'+id).removeClass('error').html('').hide();
	}
}

function enableMoreSpareCostField(id)
{
	var more_spare_parts_cks=$('#more_spare_parts_cks_'+id).is(':checked');
	if(more_spare_parts_cks==true)
	{
		$('#more_spare_cost_'+id).prop("disabled", false);	
		$('#more_spares_image_'+id).prop("disabled", false);	
	}else{
		$('#more_spare_cost_'+id).val('').prop("disabled", true);
		$('#more_spares_image_'+id).val('').prop("disabled", true);
		$('#error_more_spare_cost_'+id).removeClass('error').html('').hide();
		$('#more_error_spare_image_'+id).removeClass('error').html('').hide();
	}
}



function defaultModels()
{
	$("#subSystemSection").hide();
	$('option', '#sub_system').remove();
	default_values = { "0": "--Select Sub System--"};
	$.each(default_values, function(key, value) {   
			$('#sub_system')
			.append($('<option>', { value : key })
			.text(value)); 
	});
}


function getSubSystem(obj)
{
	defaultModels();
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	if(value>0)
	{
		$("#subSystemSection").show();
	}
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
			$('#sub_system').prop("disabled", true);
			$("#subSystemSection").hide();
			});	
		}else{
			$.each(selectValues, function(key, value) {   
			$('#sub_system')
			.append($('<option>', { value : key })
			.text(value)); 
				$("#sub_system_preloader_div").fadeOut(200,function(){
					$('#sub_system').prop("disabled", false);
				});	
			});	
		}	
	});	
}


function getSpares(obj)
{
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getSpares');?>",
	type: "POST",
	dataType: "html",
	data: {'sub_system_id' : value},
	beforeSend: function(){
		//$("#sub_system_preloader_div").show();
	}
	}).done(function(html){
		$("#more_spares_ajax_section").html(html);
		$('.more_cost_field_element').numeric();
	});	
}



$('.cost_field_element').numeric();
highlightMenu('Bookings');
highlightMenu('Job Card');
highlightMenu('Maintainance Report');


function showSpares()
{
	$("#BookingComments_comment").val('');
	$("#comments_section").show();
	$("#hide_comment").show();
	$("#add_comment").hide();
}

function hideSpares()
{
	$("#BookingComments_comment").val('');
	$("#comments_section").hide();
	$("#hide_comment").hide();
	$("#add_comment").show();
	$('.spare_parts_cks').prop('checked', false);
	$("#spare_parts_section").hide();
	$("#hide_all_spares").hide();
	$("#add_all_spares").show();
}


function showAllSpares()
{
	$("#spare_parts_section").show();
	$("#hide_all_spares").show();
	$("#add_all_spares").hide();
	$("#add_more_spares").show();
}

function hideAllSpares()
{
	$('.spare_parts_cks').prop('checked', false);
	$("#spare_parts_section").hide();
	$("#hide_all_spares").hide();
	$("#add_all_spares").show();
	$("#add_more_spares").hide();
	$("#more_spare_parts_section").hide();
	$("#hide_more_spares").hide();
	$('#sub_system').prop("disabled", true);
	// clear more spare parts selections
}


function showMoreSpares()
{
	$("#more_spare_parts_section").show();
	$("#hide_more_spares").show();
	$("#add_more_spares").hide();
}

function hideMoreSpares()
{
	$("#more_spare_parts_section").hide();
	$("#hide_more_spares").hide();
	$("#add_more_spares").show();
	$('#sub_system').prop("disabled", true);
}


function getComments()
{
	var booking_id=parseInt(<?php echo intval($model->id);?>);
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getComments');?>",
	type: "POST",
	dataType: "html",
	data: {'booking_id' : booking_id},
	beforeSend: function(){
		$("#comments_preloading_div").show();
	}
	}).done(function(html){
		$("#comments_preloading_div").hide();
		$("#booking_comments_section").html(html).show();
	});	
}


function deleteSpare(id)
{
		var controller="BookingSpares";
		var path="index.php?r="+controller+"/delete&id="+id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			getComments();
		});
}


function deleteComment(id)
{
		var controller="BookingComments";
		var path="index.php?r="+controller+"/delete&id="+id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			getComments();
		});
}


function actionBookingComment(action,id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('BookingComments/approvereject');?>",
	type: "POST",
	data: {'action' : action,'id' : id},
	beforeSend: function(){
		
	}
	}).done(function(html){
		getComments();
	});		
}




function sendData()
{
	$("#booking_comments_frm").ajaxForm({
	dataType:'html',
	success: function (html){
		$("#preloader_login_div").hide();
		$("#BookingComments_comment").val('');
		$(".cost_field_element").val('');
		$(".more_cost_field_element").val('');
		$('.spare_parts_cks').prop('checked', false);
		$('.more_spare_parts_cks').prop('checked', false);
		$('.cost_field_element').val('').prop('disabled', true);
		$('.more_spares_image_element').val('').prop('disabled', true);
		$(".cost_field_element").val('').prop("disabled", true);
		$(".more_cost_field_element").val('').prop("disabled", true);
		$("#more_spares_ajax_section").html('');
		hideAllSpares();
		hideMoreSpares();
		hideSpares();
		$("#AddMoreSpares").hide();
		$("#add_more_spares").hide();
		defaultModels();
		$("#systems").val('');
		$("#booking_details_info_div").addClass('success').removeClass('error').html('Comment has been saved.').show();
		getComments();
		
	}
	}).submit();
}



/*function sendData(data)
{	
$.ajax({ 
	url: url,
	type: "POST",
	data: {'data' : data},
	beforeSend: function(){
		$("#preloader_login_div").show();
	}
	}).done(function(html){
		//alert(html);
		$("#preloader_login_div").hide();
		$("#BookingComments_comment").val('');
		$(".cost_field_element").val('');
		$(".more_cost_field_element").val('');
		$('.spare_parts_cks').prop('checked', false);
		$('.more_spare_parts_cks').prop('checked', false);
		$(".cost_field_element").val('').prop("disabled", true);
		$(".more_cost_field_element").val('').prop("disabled", true);
		$("#more_spares_ajax_section").html('');
		hideAllSpares();
		hideMoreSpares();
		hideSpares();
		$("#AddMoreSpares").hide();
		$("#add_more_spares").hide();
		defaultModels();
		$("#systems").val('');
		$("#booking_details_info_div").addClass('success').removeClass('error').html('Comment has been saved.').show();
		getComments();
	});	
}
*/


	

function validateSpareParts()
{	
	$(".spare_parts_cks").each(function(index,element){
		var id=this.id;
		var parts=id.split('_');
		var cost_id=parts[3];
		var checked = $('#'+id).is(':checked');
		if(checked==true){
			var spare_cost=$("#spare_cost_"+cost_id).val();
			var spares_image=$("#spares_image_"+cost_id).val();
			var spares_image_ext = spares_image.split('.').pop().toLowerCase();
			if(spare_cost!==""){
				$("#error_spare_cost_"+cost_id).removeClass('error').html('').hide();
				$("#sparesErrorCount").val(0);
			}else{
				$("#error_spare_cost_"+cost_id).addClass('error').html('Please enter the cost.').show();
				$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
				$("#sparesErrorCount").val(1);
			}
			if(spares_image_ext!="")
			{
				if(spares_image_ext=="png" || spares_image_ext=="jpg" || spares_image_ext=="jpeg"){
					$("#error_spare_image_"+cost_id).removeClass('error').html('').hide();
					$("#sparesErrorCount").val(0);
				}else{
					$("#error_spare_image_"+cost_id).addClass('error').html("Please upload the Spare part photo as(.JPG or PNG).").show();
					$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
					$("#sparesErrorCount").val(1);
				}
			}else{
					$("#error_spare_image_"+cost_id).addClass('error').html("Please upload the Spare part photo ").show();
					$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
					$("#sparesErrorCount").val(1);
			}
			
		}
	});	
}




function validateMoreSpareParts()
{	
	$(".more_spare_parts_cks").each(function(index,element){
		var id=this.id;
		var parts=id.split('_');
		var cost_id=parts[4];
		var checked = $('#'+id).is(':checked');
		if(checked==true){
			var more_spare_cost=$("#more_spare_cost_"+cost_id).val();
			var more_spares_image=$("#more_spares_image_"+cost_id).val();
			var more_spares_image_ext = more_spares_image.split('.').pop().toLowerCase();
			if(more_spare_cost!==""){
				$("#error_more_spare_cost_"+cost_id).removeClass('error').html('').hide();
				$("#MoreSparesErrorCount").val(0);
			}else{
				$("#error_more_spare_cost_"+cost_id).addClass('error').html('Please enter the cost.').show();
				$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
				$("#MoreSparesErrorCount").val(1);
			}
			if(more_spares_image_ext!="")
			{
				if(more_spares_image_ext=="png" || more_spares_image_ext=="jpg" || more_spares_image_ext=="jpeg"){
					$("#more_error_spare_image_"+cost_id).removeClass('error').html('').hide();
					$("#MoreSparesErrorCount").val(0);
				}else{
					$("#more_error_spare_image_"+cost_id).addClass('error').html("Please upload the Spare part photo as(.JPG or PNG).").show();
					$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
					$("#MoreSparesErrorCount").val(1);
				}
			}else{
					$("#more_error_spare_image_"+cost_id).addClass('error').html("Please upload the Spare part photo ").show();
					$("booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
					$("#MoreSparesErrorCount").val(1);
			}
			
		}
	});	
}

function SaveBookingDetails()
{
	var BookingComments_comment=$("#BookingComments_comment").val();
	var atLeastOneIsChecked = $('.spare_parts_cks').is(':checked');
	var atLeastOneMoreIsChecked = $('.more_spare_parts_cks').is(':checked');
	if(BookingComments_comment!==""){
		$("#BookingComments_comment_error").removeClass('error').html('').hide();
		if($(".spare_parts_section").is(':visible')){
			if(atLeastOneIsChecked==true){
				$("#spares_listing_error").removeClass('error').html('').hide();
				validateSpareParts();
				var sparesErrorCount= parseInt($("#sparesErrorCount").val());
				if(sparesErrorCount==0)
				{
					if($(".more_spare_parts_section").is(':visible')){
						if(atLeastOneMoreIsChecked==true){
							$("#more_spares_listing_error").removeClass('error').html('').hide();
							
							validateMoreSpareParts();
							var MoreSparesErrorCount= parseInt($("#MoreSparesErrorCount").val());
							//alert("More spares are "+MoreSparesErrorCount);
							if(MoreSparesErrorCount==0){
								var data=$("#booking_comments_frm").serialize();
								//sendData(data);
								sendData();	
							}
						}else{
							$("#more_spares_listing_error").addClass('error').html('Please select at least one spare part.').show();
							$("#booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
							
						}
					}else{
						var data=$("#booking_comments_frm").serialize();
						//sendData(data);
						sendData();	
					}	
				}
			}else{
				
				$("#spares_listing_error").addClass('error').html('Please select at least one spare part.').show();
				$("#booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
			}
		}else{
			$("#spares_listing_error").removeClass('error').html('').hide();
			var data=$("#booking_comments_frm").serialize();
			//sendData(data);	
			sendData();
		}
	}else{
		$("#BookingComments_comment_error").addClass('error').html('Please enter the comment.').show();
		$("#booking_details_info_div").removeClass('error').removeClass('success').html('').hide();
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


function PostBooking()
{
	var current_task=$("#current_task").val();
	var Bookings_request_id=$("#Bookings_request_id").val();
	var Bookings_supplier_id=$("#Bookings_supplier_id").val();
	var Bookings_status=$("#Bookings_status").val();
	
	if(Bookings_request_id!==""){
		$("#request_error").removeClass('error').html('').hide();
		if(Bookings_supplier_id!==""){
			$("#supplier_error").removeClass('error').html('').hide();
			if(Bookings_status!==""){
				$("#status_error").removeClass('error').html('').hide();
				/*Start submit the form*/
				$('.parent_form_elements').prop("disabled", false);
				$("#save_preloader_div").show();
				$("#bookings-form").ajaxForm({
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
					$('#bookings-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Job Card successfully added.').show();
				}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Job Card successfully updated.').show();
				}
				}
				}
				}).submit();
				/*End submit the form*/
					
			}else{
				$("#status_error").addClass('error').html('Please select the status.').show();
				displayError("Please select the status.","status_error");
			}
		}else{
			displayError("Please select the supplier.","supplier_error");
		}
	}else{
		displayError("Please select the request.","request_error");
	}	
}



$(document).keypress(function(e) {
		if(e.which == 13) {
			<?php
			if($LOGGED_IN_USER_KIND!="supplier"){
				?>
				PostBooking();
				<?php
			}else{
				?>
				if($(".comments_section").is(':visible')){
					SaveBookingDetails();
				}
				<?php
			}
			?>
			
		}
	});	
$(document).ready(function(){
getComments();
});	
</script>
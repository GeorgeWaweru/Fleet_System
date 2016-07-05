<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-systems-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('autocomplete'=>'off'),
)); ?>


<table>

<tr>
<td width="75">
<b>Car System</b>
</td>
<td>
<?php
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) :0;
$sql="SELECT * FROM tbl_system WHERE id NOT IN (SELECT system_id FROM tbl_supplier_systems WHERE supplier_id=".$LOGGED_IN_USER_ID.") AND STATUS=1 AND is_default=0;";
?>
 <?php echo CHtml::activeDropDownList($model,'system_id',CHtml::listData(System::model()->findAllBySql($sql),'id','title') ,array('empty' => '--Select System--','class'=>'parent_fields parent_form_elements')); ?>
<div id="system_error"></div>
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
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostSupplierSystem()','class'=>'parent_form_btn')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>	


<?php $this->endWidget(); ?>

</div><!-- form -->
<script language="javascript" type="text/javascript">
highlightMenu('Dealers In');

function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}

function PostSupplierSystem()
{
	var current_task=$("#current_task").val();
	var SupplierSystems_system_id=$("#SupplierSystems_system_id").val();
	var SupplierSystems_status=$("#SupplierSystems_status").val();
	if(SupplierSystems_system_id!==""){
		$("#system_error").removeClass('error').html('').hide();
		if(SupplierSystems_status!==""){
			$("#status_error").removeClass('error').html('').hide();
			
			
				/*Start submit the form*/
				$('.parent_form_elements').prop("disabled", false);
				$("#save_preloader_div").show();
				$("#supplier-systems-form").ajaxForm({
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
					$('#supplier-systems-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Supplier Details successfully added.').show();
				}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Supplier Details successfully updated.').show();
				}
				}
				}
				}).submit();
				/*End submit the form*/

		}else{
			displayError("Please select the status.","status_error");
		}
	}else{
		displayError("Please select the system.","system_error");
	}	
}




$(document).keypress(function(e) {
		if(e.which == 13) {
			PostSupplierSystem();
		}
	});	
</script>
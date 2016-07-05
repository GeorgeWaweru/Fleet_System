<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roles-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<table>
<tr>
<td>
<b>Role Name</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
<div id="title_error"></div>
</td>
</tr>


<tr>
<td>
<b>Description</b>
</td>
<td>
<?php echo $form->textArea($model,'role_description',array('rows'=>6, 'cols'=>50)); ?>
<div id="role_description_error"></div>
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
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostRoles()')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>

</table>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script language="javascript" type="text/javascript">
highlightMenu('User Roles');

function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}


function PostRoles()
{
	
	var current_task=$("#current_task").val();
	var Roles_title=$("#Roles_title").val();
	var Roles_role_description=$("#Roles_role_description").val();
	var Roles_status=$("#Roles_status").val();
	
		if(Roles_title!==""){
			$("#title_error").removeClass('error').html('').hide();
			if(Roles_role_description!==""){
				$("#role_description_error").removeClass('error').html('').hide();
				if(Roles_status!==""){
					$("#status_error").removeClass('error').html('').hide();
					
					/*Start submit the form*/
					$("#save_preloader_div").show();
					$("#roles-form").ajaxForm({
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
					$('#roles-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('User Role successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('User Role successfully updated.').show();
					}
					}
					}
					}).submit();
					/*End submit the form*/					

				}else{
					displayError("Please select the status.","status_error");
				}
			}else{
				displayError("Please enter the Role description.","role_description_error");
			}
		}else{
			displayError("Please enter the User Role.","title_error");
		}	
}

$(document).keypress(function(e) {
		if(e.which == 13) {
			PostRoles();	
		}
	});
</script>
<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'suppliers-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<div class="suppliers_frm_section">
<table>
<tr>
<td width="105">
<b>Supplier Name</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
<div id="title_error"></div>
</td>
</tr>

<tr>
<td>
<b>Registration No.</b>
</td>
<td>
<?php echo $form->textField($model,'reg_no',array('size'=>50,'maxlength'=>50)); ?>
<div id="reg_no_error"></div>
</td>
</tr>

<tr>
<td>
<b>Contact Person</b>
</td>
<td>
<?php echo $form->textField($model,'contact_person',array('size'=>60,'maxlength'=>100)); ?>
<div id="contact_person_error"></div>
</td>
</tr>

<tr>
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
<div id="email_error"></div>
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
<?php echo CHtml::Button($model->isNewRecord ? 'Add' : 'Update',array('onClick'=>'PostSupplier()')); ?>
<br>
<span class="preloader_div" id="save_preloader_div"><img src="images/loader.gif" /></span>
<div id="info_frm"></div>
</td>
</tr>
</table>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->


<script language="javascript" type="text/javascript">
highlightMenu('Suppliers');


function displayError(errorMsg,error_div)
{
	$("#"+error_div).addClass('error').html(errorMsg).show();
	$('body, html').animate({
	scrollTop: $("#"+error_div).offset().top-30
	}, 1200);
	$("#info_frm").removeClass('error').removeClass('success').html('').hide();	
}

function PostSupplier()
{
	var current_task=$("#current_task").val();
	var Suppliers_title=$("#Suppliers_title").val();
	var Suppliers_reg_no=$("#Suppliers_reg_no").val();
	var Suppliers_contact_person=$("#Suppliers_contact_person").val();
	var Suppliers_email=$("#Suppliers_email").val();
	var Suppliers_status=$("#Suppliers_status").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	
	if(Suppliers_title!==""){
			$("#title_error").removeClass('error').html('').hide();
		if(Suppliers_reg_no!==""){
				$("#reg_no_error").removeClass('error').html('').hide();
				if(Suppliers_contact_person!==""){
						$("#contact_person_error").removeClass('error').html('').hide();
						if(emailReg.test(Suppliers_email) && Suppliers_email!=""){
								$("#email_error").removeClass('error').html('').hide();Suppliers_status
								if(Suppliers_status!==""){
										$("#status_error").removeClass('error').html('').hide();
										
										
										
					/*Start submit the form*/
					$("#save_preloader_div").show();
					$("#suppliers-form").ajaxForm({
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
					$('#suppliers-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Supplier successfully added.').show();
					}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Supplier successfully updated.').show();
					}
					}
					}
					}).submit();
					/*End submit the form*/
					
										
				
								}else{
									displayError("Please select the status.","status_error");
								}
						}else{
							displayError("Please enter a valid Email address.","email_error");
						}
				}else{
					displayError("Please enter the contact person.","contact_person_error");
				}
			}else{
				displayError("Please enter the registration number.","reg_no_error");
		}
		}else{
			displayError("Please enter the suppliers name.","title_error");
	}
}



$(document).keypress(function(e) {
		if(e.which == 13) {
			PostSupplier();
		}
	});	
</script>
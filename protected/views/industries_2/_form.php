<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'industries-form',
	'htmlOptions'=>array('autocomplete'=>'off','enctype' =>'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>

<table>
<tr>
<td>
<b>Industry</b>
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
<?php
Yii::import('ext.krichtexteditor.KRichTextEditor');
$this->widget('KRichTextEditor', array(
    'model' => $model,
    'value' => $model->industry_desc,
    'attribute' => 'industry_desc',
    'options' => array(
        'theme_advanced_resizing' => 'true',
        'theme_advanced_statusbar_location' => 'bottom',
		 'width'=>500,
         'height'=>300,
    ),
));
?>
<div id="industry_desc_error"></div>
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
<div id="candidate_frm_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
<div id="info_frm"></div>
</td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript" type="text/javascript">
highlightMenu('Industries');
$("form#industries-form").submit(function(event){
	event.preventDefault(); 
	var addUrl='<?php echo Yii::app()->controller->createUrl('Industries/create');?>';
	var updateUrl='<?php echo Yii::app()->controller->createUrl('Industries/update');?>';
	var current_task=$("#current_task").val();
	if(current_task=='Add'){
		url=addUrl;
	}else if(current_task=='Update'){
		url=updateUrl;
	}
	var Industries_title=$("#Industries_title").val();
	var Industries_industry_desc=$("#Industries_industry_desc").val();
	var Industries_status=$("#Industries_status").val();
	
		if(Industries_title!==""){
			$("#title_error").removeClass('error').html('').hide();
			if(Industries_industry_desc!==""){
				$("#industry_desc_error").removeClass('error').html('').hide();
				if(Industries_status!==""){
					$("#status_error").removeClass('error').html('').hide();
					
					
					
					/*Start submit the form*/
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
				$("#candidate_frm_preloader_div").hide();
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
					$('#industries-form')[0].reset();
					$("#info_frm").addClass('success').removeClass('error').html('Industry successfully added.').show();
				}else if(current_task=='Update'){
					$("#info_frm").addClass('success').removeClass('error').html('Industry successfully updated.').show();
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
				$("#industry_desc_error").addClass('error').html('Please enter the industry description.').show();
				$("#info_frm").removeClass('error').removeClass('success').html('').hide();
			}
		}else{
			$("#title_error").addClass('error').html('Please enter the Industry.').show();
			$("#info_frm").removeClass('error').removeClass('success').html('').hide();
		}
	  return false;
});


$(document).keypress(function(e) {
		if(e.which == 13) {
			$("#industries-form").submit();	
		}
	});
</script>
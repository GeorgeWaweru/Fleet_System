

<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<table>
<tr>
<td width="80">
<b>Car</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'system_id',CHtml::listData(System::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select System--','onchange'=>'getSubSystem(this)','class'=>'parent_fields')); ?>
</td>
</tr>


<tr>
<td>
<b>Sub System</b>
</td>
<td>
<select class="dropDownElements" name="Requests[subsystem_id]" id="Requests_subsystem_id">
<option value="" value="">--Select Sub System--</option>
</select>
<div id="sub_system_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
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
<td>
</td>
<td>
<?php echo CHtml::submitButton('Search'); ?>
</td>
</tr>



</table>
	

<?php $this->endWidget(); ?>

</div><!-- search-form -->
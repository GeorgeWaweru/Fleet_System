<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); ?>

<?php
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
?>

<table>
<?php
if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
?>
<tr>
<td>
<b>Company</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'company_id',CHtml::listData(Companies::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select Company--')); ?>
</td>
</tr>
<?php
}
?>


<tr>
<td width="94">
<b>Car</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'car_id',CHtml::listData(Cars::model()->findAll("status='1' AND is_default=0 AND company_id=".$LOGGED_IN_COMPANY.""),'id','number_plate') ,array('empty' => '--Select Car--')); ?>
</td>
</tr>

<tr>
<td>
<b>First Name</b>
</td>
<td>
<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Last Name</b>
</td>
<td>
<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>

<tr>
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>

<tr>
<td>
<b>Phone Number</b>
</td>
<td>
<?php echo $form->textField($model,'phone_number',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>

<tr>
<td>
<b>Qualified</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'qualified_status',array(''=>'--Select Status--','1'=>'Yes','0'=>'No')); ?>
</td>
</tr>



<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
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
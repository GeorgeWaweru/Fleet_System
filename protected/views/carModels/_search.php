<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); ?>

	
    <table>
    <tr>
   <td width="80">
    <b>Car Make</b>
    </td>
    <td>
     <?php echo CHtml::activeDropDownList($model,'make_id',CHtml::listData(CarMake::model()->findAll("status='1' AND is_default='0'"),'id','title') ,array('empty' => '--Select Car Make--')); ?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Car Model</b>
    </td>
    <td>
    <?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
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
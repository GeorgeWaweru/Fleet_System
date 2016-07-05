<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array('autocomplete'=>'off'),
)); ?>

	<table>
    
        <tr>
        <td>
        <b>First Name</b><br />
        <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
        <b>Last Name</b><br />
        <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        </tr>
    
        <tr>
        <td>
        <b>Role</b><br />
        <?php echo CHtml::activeDropDownList($model,'role_id',CHtml::listData(Roles::model()->findAll(),'id','role_name') ,array('empty' => '--Select Role--')); ?>
        </td>
        </tr>
    
   		 <tr>
        <td>
         <b>Email</b><br />
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
    </table>



	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
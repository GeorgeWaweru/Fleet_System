<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 

$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$types=isset($_REQUEST['types']) ? strtolower($_REQUEST['types']) :"";
?>

<table>
<tr>
<td>
<b>Request</b>
</td>
<td>
<?php
$Requests = Requests::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY." AND request_type='$types'");
$data = array();
foreach ($Requests as $item)
{
$CarsData=Cars::model()->findByPk($item->car_id);
$CarMake=CarMake::model()->findByPk($CarsData->make_id);
$CarModels=CarModels::model()->findByPk($CarsData->model_id);		
$UsersData=Users::model()->findByPk($item->user_id);
$created_at=$RequestsModel->fomartDate($item->created_at);
$SystemData=System::model()->findByPk($item->system_id);
$SubSystemData=SubSystem::model()->findByPk($item->subsystem_id);
$narrative=$SystemData->title." - ".$SubSystemData->title." (".$CarMake->title." ".$CarModels->title." ".$CarsData->number_plate.")"." Requested by ".$UsersData->first_name." ".$UsersData->last_name." on ".$created_at;
$data[$item->id]=$narrative;  
}
echo CHtml::activeDropDownList($model, 'request_id', $data ,array('empty' => '--Select Service Request Narrative--'));
?>
</td>
</tr>
</table>

	<div class="row">
		<?php echo $form->label($model,'request_id'); ?>
		<?php echo $form->textField($model,'request_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
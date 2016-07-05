<?php
$this->breadcrumbs=array(
	'Car Assign Mechanical Issues'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Add Car Mechanical Issue', 'url'=>array('create')),
	array('label'=>'Back To Car Assignment', 'url'=>array('CarAssignment/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#car-assign-mechanical-issues-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Car Mechanical Issues</h3>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'car-assign-mechanical-issues-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
	
	
	/*	array(
		'name' => 'check',
		'id' => 'selectedIds',
		'value' => '$data->id',
		'class' => 'CCheckBoxColumn',
		'selectableRows' => '2',
		),*/
		
		
		array(
		'header' => "Car Assignment Narrative",
		'value'=>'$data->assignmentNarative($data->car_assignment_id)',
		'htmlOptions'=>array('width'=>'380px'),
		),
		
		
		array(
		'header' => "Photo",
		'value'=>'$data->DisplayBanner($data->photo)',
		'htmlOptions'=>array('width'=>'50px'),
		),
		
		
		array(
		'header' => "Description",
		'value'=>'$data->description',
		'htmlOptions'=>array('width'=>'300px'),
		),
		
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id)',
		'htmlOptions'=>array('width'=>'100px'),
		//'visible'=>hideAdminColumn(),
		),
	),
));
?>
<input type="hidden" name="delete_record_id" id="delete_record_id">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.min.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.easy-confirm-dialog.js');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />
<script language="javascript" type="text/javascript">
highlightMenu('Cars Assignment');
$(".delete_confirm").click(function() {
	var id=$(this).attr('id');
	$("#delete_record_id").val(id);
});
$(document).ready(function() {
$(".delete_confirm").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});
$(".ui-dialog-buttonpane .ui-state-default").click(function() {
	var box_text=$(this).text();
	var delete_record_id=$("#delete_record_id").val();
	if(box_text=="Yes"){
		adminDeleteRecord('CarAssignMechanicalIssues',delete_record_id,'car-assign-mechanical-issues-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>

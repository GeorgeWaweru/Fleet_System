<?php
$this->breadcrumbs=array(
	'Systemusers'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Add Admin user', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('systemusers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<h3>Manage Admin Users</h3>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'systemusers-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
	
	array(
		'header' => 'Role',
		'value'=>'$data->role->role_name',
		),
		
		array(
		'header' => 'First Name',
		'value'=>'$data->first_name',
		),
		
		array(
		'header' => 'Last Name',
		'value'=>'$data->last_name',
		),
		
		array(
		'header' => 'Email',
		'value'=>'$data->email',
		),
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		),
		array(
			'header' => 'Edit / Delete',
			'value'=>'$data->deleteRecord($data->id,$this->grid->dataProvider->pagination->currentPage)',
			'htmlOptions'=>array('width'=>'100px'),
			),
	),
));
?>
<input type="hidden" name="delete_record_id" id="delete_record_id">

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.min.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.easy-confirm-dialog.js');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />

<script language="javascript" type="text/javascript">
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
		adminDeleteRecord('Systemusers',delete_record_id,'systemusers-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>

<?php
/* @var $this SpareController */
/* @var $model Spare */

$this->breadcrumbs=array(
	'Spares'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Spare', 'url'=>array('index')),
	array('label'=>'Add Spare Part', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#spare-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Spares</h3>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="export_add_wrapper">
<a class="export_link" href="<?php echo Yii::app()->controller->createUrl('ExportExcell');?>" target="_blank">Export Excell</a>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'spare-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
	
	/*array(
		'name' => 'check',
		'id' => 'selectedIds',
		'value' => '$data->id',
		'class' => 'CCheckBoxColumn',
		'selectableRows' => '2',
		),*/
		
		
		array(
		'header' => 'Sub System',
		'value'=>'$data->subSystem->title',
		'htmlOptions'=>array('width'=>'150px'),
		),	
		
		array(
		'header' => 'Spare Part Name',
		'value'=>'$data->title',
		'htmlOptions'=>array('width'=>'150px'),
		),	
		

		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
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
highlightMenu('Spares');
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
		adminDeleteRecord('Spare',delete_record_id,'spare-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>

<?php
$this->breadcrumbs=array(
	'Bookings'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Bookings', 'url'=>array('admin')),
	//array('label'=>'Create Bookings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bookings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Bookings</h3>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bookings-grid',
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
		'header' => 'Request',
		'value'=>'$data->requestNarrative($data->request_id)',
		'htmlOptions'=>array('width'=>'300px'),
		),
		
		array(
		'header' => 'Registration Number',
		'value'=>'$data->request->car->number_plate',
		'htmlOptions'=>array('width'=>'160px'),
		),	
		
		array(
		'header' => 'Request type',
		'value'=>'ucfirst($data->request_type)',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
		array(
		'header' => 'Supplier(Garage)',
		'value'=>'$data->supplier->title',
		'htmlOptions'=>array('width'=>'130px'),
		),
		
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
	
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,"service")',
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
highlightMenu('Bookings');

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
		adminDeleteRecord('Bookings',delete_record_id,'bookings-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>


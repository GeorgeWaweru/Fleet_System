<?php
/* @var $this SupplierSystemsController */
/* @var $model SupplierSystems */

$this->breadcrumbs=array(
	'Supplier Systems'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SupplierSystems', 'url'=>array('index')),
	array('label'=>'Create SupplierSystems', 'url'=>array('create')),
	array('label'=>'Update SupplierSystems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SupplierSystems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SupplierSystems', 'url'=>array('admin')),
);
?>

<h1>View SupplierSystems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'system_id',
		'supplier_id',
		'status',
	),
)); ?>

<?php
/* @var $this CompanySuppliersController */
/* @var $model CompanySuppliers */

$this->breadcrumbs=array(
	'Company Suppliers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CompanySuppliers', 'url'=>array('index')),
	array('label'=>'Create CompanySuppliers', 'url'=>array('create')),
	array('label'=>'Update CompanySuppliers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CompanySuppliers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompanySuppliers', 'url'=>array('admin')),
);
?>

<h1>View CompanySuppliers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'supplier_id',
		'company_id',
		'created_at',
		'status',
	),
)); ?>

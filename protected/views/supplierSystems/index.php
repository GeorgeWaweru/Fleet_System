<?php
/* @var $this SupplierSystemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Supplier Systems',
);

$this->menu=array(
	array('label'=>'Create SupplierSystems', 'url'=>array('create')),
	array('label'=>'Manage SupplierSystems', 'url'=>array('admin')),
);
?>

<h1>Supplier Systems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

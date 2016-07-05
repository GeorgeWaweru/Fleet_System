<?php
/* @var $this SupplierSystemsController */
/* @var $model SupplierSystems */

$this->breadcrumbs=array(
	'Supplier Systems'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List SupplierSystems', 'url'=>array('index')),
	array('label'=>'Create SupplierSystems', 'url'=>array('create')),
	array('label'=>'View SupplierSystems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SupplierSystems', 'url'=>array('admin')),
);
?>

<h3>Update SupplierSystems <?php echo $model->id; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this CompanySuppliersController */
/* @var $model CompanySuppliers */

$this->breadcrumbs=array(
	'Company Suppliers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompanySuppliers', 'url'=>array('index')),
	array('label'=>'Create CompanySuppliers', 'url'=>array('create')),
	array('label'=>'View CompanySuppliers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CompanySuppliers', 'url'=>array('admin')),
);
?>

<h1>Update CompanySuppliers <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
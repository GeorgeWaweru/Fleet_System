<?php
/* @var $this CompanySuppliersController */
/* @var $model CompanySuppliers */

$this->breadcrumbs=array(
	'Company Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompanySuppliers', 'url'=>array('index')),
	array('label'=>'Manage CompanySuppliers', 'url'=>array('admin')),
);
?>

<h1>Create CompanySuppliers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
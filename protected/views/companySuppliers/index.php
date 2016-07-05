<?php
/* @var $this CompanySuppliersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Company Suppliers',
);

$this->menu=array(
	array('label'=>'Create CompanySuppliers', 'url'=>array('create')),
	array('label'=>'Manage CompanySuppliers', 'url'=>array('admin')),
);
?>

<h1>Company Suppliers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

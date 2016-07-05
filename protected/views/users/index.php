<?php
/* @var $this DriversController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Drivers',
);

$this->menu=array(
	array('label'=>'Create Drivers', 'url'=>array('create')),
	array('label'=>'Manage Drivers', 'url'=>array('admin')),
);
?>

<h1>Drivers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

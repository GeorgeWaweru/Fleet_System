<?php
/* @var $this SpareController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spares',
);

$this->menu=array(
	array('label'=>'Create Spare', 'url'=>array('create')),
	array('label'=>'Manage Spare', 'url'=>array('admin')),
);
?>

<h1>Spares</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

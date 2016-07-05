<?php
/* @var $this CarMakeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Makes',
);

$this->menu=array(
	array('label'=>'Create CarMake', 'url'=>array('create')),
	array('label'=>'Manage CarMake', 'url'=>array('admin')),
);
?>

<h1>Car Makes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

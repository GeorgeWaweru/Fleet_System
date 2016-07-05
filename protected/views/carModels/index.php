<?php
/* @var $this CarModelsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Models',
);

$this->menu=array(
	array('label'=>'Create CarModels', 'url'=>array('create')),
	array('label'=>'Manage CarModels', 'url'=>array('admin')),
);
?>

<h1>Car Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

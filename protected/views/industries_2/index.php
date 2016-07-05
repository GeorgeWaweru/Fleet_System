<?php
/* @var $this IndustriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Industries',
);

$this->menu=array(
	array('label'=>'Create Industries', 'url'=>array('create')),
	array('label'=>'Manage Industries', 'url'=>array('admin')),
);
?>

<h1>Industries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this CarMechanicalIssuesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Mechanical Issues',
);

$this->menu=array(
	array('label'=>'Create CarMechanicalIssues', 'url'=>array('create')),
	array('label'=>'Manage CarMechanicalIssues', 'url'=>array('admin')),
);
?>

<h1>Car Mechanical Issues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

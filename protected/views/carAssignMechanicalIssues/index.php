<?php
/* @var $this CarAssignMechanicalIssuesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Assign Mechanical Issues',
);

$this->menu=array(
	array('label'=>'Create CarAssignMechanicalIssues', 'url'=>array('create')),
	array('label'=>'Manage CarAssignMechanicalIssues', 'url'=>array('admin')),
);
?>

<h1>Car Assign Mechanical Issues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

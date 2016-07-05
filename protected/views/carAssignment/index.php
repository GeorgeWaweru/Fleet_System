<?php
/* @var $this CarAssignmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Assignments',
);

$this->menu=array(
	array('label'=>'Create CarAssignment', 'url'=>array('create')),
	array('label'=>'Manage CarAssignment', 'url'=>array('admin')),
);
?>

<h1>Car Assignments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

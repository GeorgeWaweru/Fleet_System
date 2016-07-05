<?php
/* @var $this CarYearsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Years',
);

$this->menu=array(
	array('label'=>'Create CarYears', 'url'=>array('create')),
	array('label'=>'Manage CarYears', 'url'=>array('admin')),
);
?>

<h1>Car Years</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

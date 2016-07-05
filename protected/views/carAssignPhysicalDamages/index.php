<?php
/* @var $this CarAssignPhysicalDamagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Assign Physical Damages',
);

$this->menu=array(
	array('label'=>'Create CarAssignPhysicalDamages', 'url'=>array('create')),
	array('label'=>'Manage CarAssignPhysicalDamages', 'url'=>array('admin')),
);
?>

<h1>Car Assign Physical Damages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

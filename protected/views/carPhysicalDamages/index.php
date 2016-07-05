<?php
/* @var $this CarPhysicalDamagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Physical Damages',
);

$this->menu=array(
	array('label'=>'Create CarPhysicalDamages', 'url'=>array('create')),
	array('label'=>'Manage CarPhysicalDamages', 'url'=>array('admin')),
);
?>

<h1>Car Physical Damages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

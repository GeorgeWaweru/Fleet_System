<?php
/* @var $this BookingSparesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Booking Spares',
);

$this->menu=array(
	array('label'=>'Create BookingSpares', 'url'=>array('create')),
	array('label'=>'Manage BookingSpares', 'url'=>array('admin')),
);
?>

<h1>Booking Spares</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this BookingSparesController */
/* @var $model BookingSpares */

$this->breadcrumbs=array(
	'Booking Spares'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookingSpares', 'url'=>array('index')),
	array('label'=>'Manage BookingSpares', 'url'=>array('admin')),
);
?>

<h1>Create BookingSpares</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
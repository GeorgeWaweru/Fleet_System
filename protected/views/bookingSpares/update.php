<?php
/* @var $this BookingSparesController */
/* @var $model BookingSpares */

$this->breadcrumbs=array(
	'Booking Spares'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookingSpares', 'url'=>array('index')),
	array('label'=>'Create BookingSpares', 'url'=>array('create')),
	array('label'=>'View BookingSpares', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BookingSpares', 'url'=>array('admin')),
);
?>

<h1>Update BookingSpares <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
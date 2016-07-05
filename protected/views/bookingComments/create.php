<?php
/* @var $this BookingCommentsController */
/* @var $model BookingComments */

$this->breadcrumbs=array(
	'Booking Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookingComments', 'url'=>array('index')),
	array('label'=>'Manage BookingComments', 'url'=>array('admin')),
);
?>

<h1>Create BookingComments</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
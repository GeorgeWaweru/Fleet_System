<?php
/* @var $this BookingCommentsController */
/* @var $model BookingComments */

$this->breadcrumbs=array(
	'Booking Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookingComments', 'url'=>array('index')),
	array('label'=>'Create BookingComments', 'url'=>array('create')),
	array('label'=>'View BookingComments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BookingComments', 'url'=>array('admin')),
);
?>

<h1>Update BookingComments <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
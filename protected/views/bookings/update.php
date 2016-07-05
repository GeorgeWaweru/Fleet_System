<?php
/* @var $this BookingsController */
/* @var $model Bookings */

$this->breadcrumbs=array(
	'Bookings'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Bookings', 'url'=>array('index')),
	//array('label'=>'Create Bookings', 'url'=>array('create')),
	//array('label'=>'View Bookings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Bookings', 'url'=>array('admin')),
);

$type=isset($_REQUEST['type']) ? $_REQUEST['type'] :'';
?>

<h3>Update <font color="red"><b><?php echo ucfirst($model->request_type);?></b></font> request Booking</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
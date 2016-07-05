<?php
$this->breadcrumbs=array(
	'Bookings'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Bookings', 'url'=>array('index')),
	array('label'=>'Manage Bookings', 'url'=>array('admin')),
);

$type=isset($_REQUEST['type']) ? base64_decode($_REQUEST['type']) :'';
?>

<h3>Create a <font color="red"><b><?php echo ucfirst($type);?></b></font> request Job Card</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
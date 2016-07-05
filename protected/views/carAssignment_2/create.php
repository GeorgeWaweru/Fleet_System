<?php
$this->breadcrumbs=array(
	'Car Assignments'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List CarAssignment', 'url'=>array('index')),
	array('label'=>'Manage Car Assignment', 'url'=>array('admin')),
);
?>

<h3>Assign a car to a user.</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
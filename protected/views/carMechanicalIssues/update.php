<?php
$this->breadcrumbs=array(
	'Car Mechanical Issues'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Car Mechanical Issues', 'url'=>array('admin')),
	array('label'=>'Back To Cars', 'url'=>array('Cars/admin')),
);
?>

<h3>Update Car Mechanical Issues</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Car Assign Physical Damages'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Physical Damages', 'url'=>array('admin')),
	array('label'=>'Back To Car Assignment', 'url'=>array('CarAssignment/admin')),
);
?>

<h3>Update Physical Damages</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Car Assign Physical Damages'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Physical Damages', 'url'=>array('admin')),
	array('label'=>'Back To Car Assignment', 'url'=>array('CarAssignment/admin')),
);
?>

<h3>Add Car Physical Damage</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
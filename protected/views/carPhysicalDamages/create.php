<?php
$this->breadcrumbs=array(
	'Car Physical Damages'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Car Physical Damages', 'url'=>array('admin')),
	array('label'=>'Back To Cars', 'url'=>array('Cars/admin')),
);
?>

<h3>Add Car Physical Damage</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
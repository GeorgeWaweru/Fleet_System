<?php
$this->breadcrumbs=array(
	'Cars'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Cars', 'url'=>array('admin')),
	//array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h3>Add Car</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
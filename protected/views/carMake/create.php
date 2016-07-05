<?php
$this->breadcrumbs=array(
	'Car Makes'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Car Make', 'url'=>array('index')),
	array('label'=>'Manage Car Make', 'url'=>array('admin')),
);
?>

<h3>Add Car Make</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
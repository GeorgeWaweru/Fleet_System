<?php
$this->breadcrumbs=array(
	'Cars'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Cars', 'url'=>array('index')),
	//array('label'=>'Create Cars', 'url'=>array('create')),
	//array('label'=>'View Cars', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h3>Update Car</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
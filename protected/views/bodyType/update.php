<?php
$this->breadcrumbs=array(
	'Body Types'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List BodyType', 'url'=>array('index')),
	//array('label'=>'Create BodyType', 'url'=>array('create')),
	//array('label'=>'View BodyType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BodyType', 'url'=>array('admin')),
);
?>

<h3>Update Body Type</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
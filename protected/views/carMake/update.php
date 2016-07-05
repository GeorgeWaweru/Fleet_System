<?php
$this->breadcrumbs=array(
	'Car Makes'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Car Make', 'url'=>array('index')),
	//array('label'=>'Create CarMake', 'url'=>array('create')),
	//array('label'=>'View CarMake', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Car Make', 'url'=>array('admin')),
);
?>

<h3>Update Car Make</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
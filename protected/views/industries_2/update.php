<?php
$this->breadcrumbs=array(
	'Industries'=>array('index'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Industries', 'url'=>array('index')),
	//array('label'=>'Create Industries', 'url'=>array('create')),
	//array('label'=>'View Industries', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Industries', 'url'=>array('admin')),
);
?>

<h3>Update Industries</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
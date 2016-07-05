<?php
/* @var $this SubSystemController */
/* @var $model SubSystem */

$this->breadcrumbs=array(
	'Sub Systems'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List SubSystem', 'url'=>array('index')),
	//array('label'=>'Create SubSystem', 'url'=>array('create')),
	//array('label'=>'View SubSystem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SubSystem', 'url'=>array('admin')),
);
?>

<h3>Update Sub System</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
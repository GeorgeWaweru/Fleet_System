<?php
/* @var $this RequestCommentsController */
/* @var $model RequestComments */

$this->breadcrumbs=array(
	'Request Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RequestComments', 'url'=>array('index')),
	array('label'=>'Create RequestComments', 'url'=>array('create')),
	array('label'=>'View RequestComments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RequestComments', 'url'=>array('admin')),
);
?>

<h1>Update RequestComments <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
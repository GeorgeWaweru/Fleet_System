<?php
/* @var $this RequestsController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'Requests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Requests', 'url'=>array('index')),
	array('label'=>'Create Requests', 'url'=>array('create')),
	array('label'=>'View Requests', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Requests', 'url'=>array('admin')),
);
?>

<h1>Update Requests <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
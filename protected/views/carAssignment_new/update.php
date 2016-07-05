<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */

$this->breadcrumbs=array(
	'Car Assignments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarAssignment', 'url'=>array('index')),
	array('label'=>'Create CarAssignment', 'url'=>array('create')),
	array('label'=>'View CarAssignment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarAssignment', 'url'=>array('admin')),
);
?>

<h1>Update CarAssignment <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
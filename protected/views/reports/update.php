<?php
/* @var $this ReportsController */
/* @var $model Votes */

$this->breadcrumbs=array(
	'Votes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Votes', 'url'=>array('index')),
	array('label'=>'Create Votes', 'url'=>array('create')),
	array('label'=>'View Votes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Votes', 'url'=>array('admin')),
);
?>

<h1>Update Votes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
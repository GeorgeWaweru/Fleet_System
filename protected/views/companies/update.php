<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Companies', 'url'=>array('index')),
	//array('label'=>'Create Companies', 'url'=>array('create')),
	//array('label'=>'View Companies', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h3>Update Company</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this SubSystemController */
/* @var $model SubSystem */

$this->breadcrumbs=array(
	'Sub Systems'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List SubSystem', 'url'=>array('index')),
	array('label'=>'Manage Sub Systems', 'url'=>array('admin')),
);
?>

<h3>Add SubSystem</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
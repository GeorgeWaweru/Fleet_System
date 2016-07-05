<?php
$this->breadcrumbs=array(
	'Body Types'=>array('admin'),
	'Create',
);

$this->menu=array(
	// array('label'=>'List BodyType', 'url'=>array('index')),
	array('label'=>'Manage Body Types', 'url'=>array('admin')),
);
?>

<h3>Add Body Type</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Companies', 'url'=>array('index')),
	array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h3>Add Company</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
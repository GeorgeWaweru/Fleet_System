<?php
$this->breadcrumbs=array(
	'Car Assignments'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List CarAssignment', 'url'=>array('index')),
	//array('label'=>'Create CarAssignment', 'url'=>array('create')),
	//array('label'=>'View CarAssignment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Car Assignment', 'url'=>array('admin')),
);
?>
<h3>Update CarAssignment</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
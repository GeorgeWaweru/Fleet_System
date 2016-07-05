<?php
$this->breadcrumbs=array(
	'Car Assign Mechanical Issues'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Mechanical Issues', 'url'=>array('admin')),
	array('label'=>'Back To Car Assignment', 'url'=>array('CarAssignment/admin')),
);
?>
<h3>Update Mechanical Issue</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Request Sub Details'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);


$type=isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) :"";
if($type=='service'){
	$title='Service';
}if($type=='repair'){
	$title='Repair';
}if($type=='fuel'){
	$title='Fuel';
}


$this->menu=array(
	array('label'=>'Add Request Details', 'url'=>array('create','type'=>$type)),
	array('label'=>'Manage Request Details', 'url'=>array('admin','type'=>$type)),
);
?>

<h3>Update <?php echo $title; ?> Request Details</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
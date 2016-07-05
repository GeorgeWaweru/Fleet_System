<?php
$this->breadcrumbs=array(
	'Request Sub Details'=>array('admin'),
	'Create',
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
	array('label'=>'Manage Request Details', 'url'=>array('admin','type'=>strtolower($title))),
);
?>

<h3>Add <?php echo $title; ?> Request Details</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Systemusers'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Systemusers', 'url'=>array('index')),
	array('label'=>'Manage Systemusers', 'url'=>array('admin')),
);*/
?>

<h3>Add Admin User</h3>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
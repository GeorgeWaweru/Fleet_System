<?php
$this->breadcrumbs=array(
	'Systemusers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Systemusers', 'url'=>array('index')),
	array('label'=>'Create Systemusers', 'url'=>array('create')),
	array('label'=>'Update Systemusers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Systemusers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Systemusers', 'url'=>array('admin')),
);
?>

<h3>View Admin User</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
			'name'=>'User',
			'type'=>'text',
			'value'=>$model->role->role_name,
		),
		
		array(
			'name'=>'First Name',
			'type'=>'text',
			'value'=>$model->first_name,
		),
		
		array(
			'name'=>'Last Name',
			'type'=>'text',
			'value'=>$model->last_name,
		),
		
		array(
			'name'=>'Email',
			'type'=>'text',
			'value'=>$model->email,
		),
		
		array(
			'name'=>'Status',
			'type'=>'text',
			'value'=>$model->status,
		),
	),
)); ?>

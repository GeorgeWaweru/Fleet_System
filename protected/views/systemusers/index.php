<?php
$this->breadcrumbs=array(
	'Systemusers',
);

$this->menu=array(
	array('label'=>'Create Systemusers', 'url'=>array('create')),
	array('label'=>'Manage Systemusers', 'url'=>array('admin')),
);
?>

<h1>Systemusers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

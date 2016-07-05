<?php
/* @var $this SubSystemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sub Systems',
);

$this->menu=array(
	array('label'=>'Create SubSystem', 'url'=>array('create')),
	array('label'=>'Manage SubSystem', 'url'=>array('admin')),
);
?>

<h1>Sub Systems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

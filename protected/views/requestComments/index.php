<?php
/* @var $this RequestCommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Request Comments',
);

$this->menu=array(
	array('label'=>'Create RequestComments', 'url'=>array('create')),
	array('label'=>'Manage RequestComments', 'url'=>array('admin')),
);
?>

<h1>Request Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

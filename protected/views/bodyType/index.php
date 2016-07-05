<?php
/* @var $this BodyTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Body Types',
);

$this->menu=array(
	array('label'=>'Create BodyType', 'url'=>array('create')),
	array('label'=>'Manage BodyType', 'url'=>array('admin')),
);
?>

<h1>Body Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
